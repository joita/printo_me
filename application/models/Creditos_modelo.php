<?php
	
class Creditos_modelo extends CI_Model {

	public function __construct()
	{
			parent::__construct();
	}

	public function use_credits($id_cliente, $total)
	{
		$res =$this->total_credito_cliente($id_cliente, $total);
		$item = array();

		$uso = date("Y-m-d H:i:s",time("now"));
		foreach ($res->ids as $id) {
			$item['estatus'] = 1;
			$item['fecha_uso'] = $uso;
			$this->db->where('id_credito', $id);
			$this->db->update('Creditos', $item);
		}

		if ($res->restore > 0) {
			$points = new Stdclass;

			$points->monto_credito  =  $res->restore;
			$points->motivo         =  "RESTANTE COMPRA ANTERIOR";
			$points->fecha_creacion = $uso;
			$points->id_cliente     = $id_cliente;
			$points->estatus        =  0;

			$this->db->insert('Creditos', $points);
		}

		return $res->total;

	}

	public function total_credito_cliente($id_cliente, $total) {

		$return = new Stdclass;
		
		$sql = "SELECT * FROM Creditos WHERE id_cliente=$id_cliente AND estatus=0 AND fecha_uso IS NULL AND (minimo_compra IS NULL OR minimo_compra >= $total) ORDER BY fecha_creacion ASC";
		$credito_res = $this->db->query($sql);
		$creditos = $credito_res->result();

		$acumulado = 0;
		$diferencia = 0;
		$sobrepasa = false;
		$ids = array();
		foreach ($creditos as $credito) {
			if ($acumulado >= $total) {
				break;
			}
			$ids[] = $credito->id_credito;
			$acumulado = $acumulado + ($credito->monto_credito*1);
		}

		$diferencia = $total - $acumulado;

		if ($diferencia < 0) {
			$return->restore = $diferencia * -1;
			$return->pagable = 0;
			$return->total = $total;
		}else{
			$return->restore = 0;
			$return->total = $total - $diferencia;
			$return->pagable = $diferencia;
		}

		$return->ids = $ids;

		return $return;
	}

	public function add_cupon_to_client($total, $id_cliente)
	{
		if (!is_null($id_cliente)) {
			$points = new Stdclass;

			$points->monto_credito  =  50;
			$points->motivo         =  "Cupon Referido";
			$points->fecha_creacion = date("Y-m-d H:i:s",time("now"));
			$points->id_cliente     = $id_cliente ;
			$points->estatus        =  0;

			$point = $this->db->insert("Creditos", $points);
			$id_points = $this->db->insert_id();
		}

		return false;

	}

}