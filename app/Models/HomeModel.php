<?php

namespace App\Models;

use CodeIgniter\Model;
class HomeModel extends Model
{
	protected $db;
	public function __construct()
	{
		$this->db = db_connect();
	}

	public function register($data)
	{
		return $this->db->table('users')->insert($data);
	}

	public function getId($username)
	{
		return $this->db->table('users')->where('username', $username)->get()->getRowArray();
	}

	public function addToCart($data)
	{
		return $this->db->table('cart')->insert($data);
	}

	public function authenticate($data)
	{
		return $this->db->table('users')
						->where('username', $data['username'])
						->where('password', $data['password'])
						->get()
						->getRowArray();
	}

	public function getCartData($id)
	{
		return $this->db->table('cart')
						->where('userid', $id)
						->get()
						->getResultArray();
	}

	public function checkCart($data)
	{
		if ($data['from'] == 'dashbaord')
		{
			return $this->db->table('cart')
							->where('userid', $data['userid'])
							->where('item_id', $data['items_id'])
							->get()
							->getRowArray();
		}

		return $this->db->table('cart')
							->where('userid', $data['userid'])
							->where('id', $data['items_id'])
							->get()
							->getRowArray();
	}

	public function updateCart($data)
	{
		return $this->db->table('cart')
						->where('id', $data['item_id'])
						->where('userid', $data['userid'])
						->set('quantity', $data['quantity'])
						->update();
	}

	public function removeItem($id, $userid)
	{
		return $this->db->table('cart')
						->where('id', $id)
						->where('userid', $userid)
						->delete();
	}

	public function checkoutCart($id)
	{
		return $this->db->table('cart')
						->where('userid', $id)
						->delete();
	}
}