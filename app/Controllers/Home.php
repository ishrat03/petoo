<?php
namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use App\Models;
class Home extends BaseController
{
	protected $homeModel;
	protected $session;
	public function __construct()
	{
		$this->homeModel = new Models\HomeModel();
		$this->session = session();
	}
	public function index()
	{
		$url = 'https://jsonblob.com/api/jsonBlob/dc64aa7c-4510-11eb-a6f4-13f5a43f0e16';

		$result = array(
			'data' => $this->prepareData($this->curlGet($url)),
			'isLoggesin' => (array_key_exists("username", $this->session->get())) ? 'yes': 'no',
			'username' => (array_key_exists("username", $this->session->get())) ? $this->session->get('name'): ''
		);

		return view('welcome_message', $result);
	}

	public function curlGet($url)
	{
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if ($output === false)
        {
        	$output = false;
        }
        curl_close($ch);     

        return $output;
	}

	public function prepareData($data)
	{
		if ($data == false)
		{
			return array();
		}

		$cartItems = array();
		if (array_key_exists('username', $this->session->get()))
		{
			$cartItems = array_column($this->homeModel->getCartData($this->session->get('id')), 'item_id');
		}

		$data = json_decode($data);
		$i = 0;
		$response = array();
		$menuItems = (array)$data->menu_items;
		$descriptions = (array)$data->menu_description;
		$j = 0;
		foreach ($menuItems as $key => $value)
		{
			$value = (array)$value;
			$response['card'][$i][$j] = $value;
			$response['card'][$i][$j]['description'] = $descriptions[$value['item_id']];
			$response['card'][$i][$j]['disabled'] = (in_array($value['item_id'], $cartItems)) ? true: false;

			$response['json'][$value['item_id']] = $value;

			$j++;
			if (fmod($key, 6) == 0 && $key !== 0)
			{
				$i++;
				$j = 0;
			}
		}

		return $response;
	}

	public function register()
	{
		$data = $this->request->getPOST();

		if ($data['name'] == '' || $data['username'] == '' || $data['password'] == '')
		{
			$result = array('status' => 'error', 'msg' => 'Invalid Details provided');

			return $this->response->setJSON($result);
		}

		$data['password'] = md5($data['password']);
		if ($this->homeModel->register($data))
		{
			$id = $this->homeModel->getId($data['username']);
			$data['id'] = $id['id'];
			$this->session->set($data);
			$result = array('status' => 'success', 'msg' => 'registerd');
			return $this->response->setJSON($result);
		}
	}

	public function login()
	{
		$data = array(
			'username' => $this->request->getPOST('username'),
			'password' => md5($this->request->getPOST('password')),
		);

		$result = $this->homeModel->authenticate($data);

		if (empty($result))
		{
			return $this->response->setJSON(array('status' => 'error', 'msg' => 'Invalid username or password'));
		}

		unset($result['password']);
		$this->session->set($result);

		return $this->response->setJSON(array('status' => 'success', 'msg' => 'Logged in Successfully'));
	}

	public function addToCart()
	{
		$id = $this->request->getPOST('id');
		$type = $this->request->getPOST('type');

		if (array_key_exists('id', $this->session->get()))
		{
			$cartData = $this->homeModel->checkCart(array(
				'items_id' => $id,
				'userid' => $this->session->get('id'),
				'from' => $this->request->getPOST('from'),
			));

			if (!empty($cartData))
			{
				$data = array(
					'quantity' => ($cartData['quantity'] + 1),
					'item_id' => $id,
					'userid' => $this->session->get('id')
				);

				//remove item from cart
				if ($type == 'minus')
				{
					if ((int)$cartData['quantity'] == 1)
					{
						if ($this->homeModel->removeItem($id, $this->session->get('id')))
						{
							return $this->response->setJSON(array(
								'status' => 'success',
								'msg' => 'Your Cart Item removed Successfully',
								'id' => $cartData['item_id'],
								'remove' => 'yes'
							));
						}
						
						return $this->response->setJSON(array('status' => 'error', 'msg' => 'Facing some technical error'));
					}

					$data = array(
						'quantity' => ($cartData['quantity'] - 1),
						'item_id' => $id,
						'userid' => $this->session->get('id')
					);
				}

				if ($this->homeModel->updateCart($data))
				{
					return $this->response->setJSON(array('status' => 'success', 'msg' => 'Your Cart Item updated Successfully', 'remove' => 'no'));
				}
				
				return $this->response->setJSON(array('status' => 'error', 'msg' => 'Facing some technical error'));
			}

			$data = array('item_id' => $id, 'quantity' => 1, 'userid' => $this->session->get('id'));

			if ($this->homeModel->addToCart($data))
			{
				return $this->response->setJSON(array('status' => 'success', 'msg' => 'Item Successfully added to Card', 'remove' => 'no'));
			}
			
			return $this->response->setJSON(array('status' => 'error', 'msg' => 'Facing some technical error'));
		}
	}

	public function cartItems()
	{
		$data['data'] = $this->cartData($this->homeModel->getCartData($this->session->get('id')));

		return $this->response->setJSON(array(
			'status' => 'success',
			'html' => view('cartView', $data),
			'isData' => (empty($data['data'])) ? 'no': 'yes',
		));
	}

	public function cartData($data)
	{
		if (!empty($data))
		{
			$url = 'https://jsonblob.com/api/jsonBlob/dc64aa7c-4510-11eb-a6f4-13f5a43f0e16';
			$menuItems = $this->curlGet($url);

			foreach ($data as $key => $value)
			{
				$value['name'] = $this->getName($menuItems, $value['item_id']);
				$data[$key] = $value;
			}
		}

		return $data;
	}

	public function getName($data, $itemId)
	{
		$data = json_decode($data);

		if (!empty($data))
		{
			foreach ($data->menu_items as $value)
			{
				if ($value->item_id == $itemId)
				{
					return $value->item_name;
				}
			}
		}
	}

	public function logout()
	{
		$this->session->destroy();

		return $this->response->setJSON(array('status' => 'success'));
	}

	public function checkout()
	{
		if ($this->homeModel->checkoutCart($this->session->get('id')))
		{
			return $this->response->setJSON(array('status' => 'success', 'msg' => "Your order places Successfully"));
		}

		return $this->response->setJSON(array('status' => 'error', 'msg' => "Facing some technical error"));
	}
}
