<?php
	
class Devoluciones_modelo extends CI_Model {

	public function all()
	{
		$this->db->select('*, ');
		$this->db->from('Devoluciones');
		$this->db->join('Pedidos', 'Pedidos.id_pedido = Devoluciones.id_pedido');
		$this->db->join('Clientes', 'Clientes.id_cliente = Pedidos.id_cliente');
		$minima_res = $this->db->get();

		return $minima_res->result();
	}

	public function get($id)
	{
		$this->db->select('*');
		$this->db->from('ProductosDevueltos');
		$this->db->join('ProductosPorPedido', 'ProductosDevueltos.id_ppp = ProductosPorPedido.id_ppp');
		$this->db->join('CatalogoSkuPorProducto', 'CatalogoSkuPorProducto.id_sku = ProductosPorPedido.id_sku');
		$this->db->join('ColoresPorProducto', 'CatalogoSkuPorProducto.id_color = ColoresPorProducto.id_color');
		$this->db->join('CatalogoProductos', 'ColoresPorProducto.id_producto = CatalogoProductos.id_producto');
		$this->db->where('id_devolucion', $id);
		$minima_res = $this->db->get();

		return $minima_res->result();
	}

}