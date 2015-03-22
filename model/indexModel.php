<?php
class Index extends Conectar
{
	private $tables;
	private $table_detail;
	private $generator;
	private $tabla;
	private $datos;
	private $initial_table;
	private $get_table_generator;
	private $table_generator;
	private $get_column_generator;

	public function check_database()
	{
		if(empty($_POST["database"]) and empty($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=1");
			exit;
		}
		else
		{
			if(!isset($_SESSION["database"]))
			{
				$_SESSION["database"] = $_POST["database"];
			}
			$database = $_SESSION["database"];
			parent::con($database);

			$sql = "SHOW tables FROM $database";
			$res = mysql_query($sql);
			while($reg = mysql_fetch_array($res))
			{
				$this->tables[]=$reg;
			}
			return $this->tables;
		}
	}

	public function check_table()
	{
		if (!isset($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=3");
			exit;
		}
		else
		{
			$table = $_GET["table"];
			$database = $_SESSION["database"];

			parent::con($database);

			$sql = "SHOW columns FROM " . $table;
			$res = mysql_query($sql);
			while($reg = mysql_fetch_array($res))
			{
				$this->table_detail[]=$reg;
			}
			return $this->table_detail;
		}
	}

	public function finish()
	{
		session_destroy();
		header("Location: ".Conectar::ruta()."?accion=index");
		exit;
	}

	public function get_table_generator()
	{
		if (!isset($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=3");
			exit;
		}
		else
		{
			parent::con("generador");

			$sql = "SHOW tables FROM generador";
			$res = mysql_query($sql);
			while($reg = mysql_fetch_array($res))
			{
				$this->get_table_generator[]=$reg;
			}

			return $this->get_table_generator;
		}
	}

	public function get_column_generator()
	{
		if (!isset($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=3");
			exit;
		}
		else
		{
			parent::con("generador");

			$sql = "SHOW tables FROM generador";
			$res = mysql_query($sql);
			while($reg = mysql_fetch_array($res))
			{
				$this->table_generator[]=$reg;
			}

			$tables_generator = $this->table_generator;
			for($i = 0; $i < count($tables_generator); $i++)
			{
				$sql = "SHOW columns FROM " . $tables_generator[$i][0];
				$res = mysql_query($sql);
				while($reg = mysql_fetch_array($res))
				{
					$this->get_column_generator[] = array($reg, 'table' => $tables_generator[$i][0]);
				}
			}
			return $this->get_column_generator;
		}
	}

	public function process()
	{
		if (!isset($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=3");
			exit;
		}
		else
		{
			$column = $_GET['column'];
			$database = $_SESSION["database"];

			// Recuperando nombre del id auto_increment de initial_table
			$resultado = mysql_query("SHOW COLUMNS FROM ".$_POST['initial_table'], parent::con($database));
			if (!$resultado)
			{
			    echo 'No se pudo ejecutar la consulta: ' . mysql_error();
			    exit;
			}
			if (mysql_num_rows($resultado) > 0)
			{
			    while ($fila = mysql_fetch_assoc($resultado))
			    {
			    	if($fila['Extra'] == 'auto_increment')
			    	{
			    		$id = $fila['Field'];
			    	}
			    }
			}

			// Verificando los campos que correspondan a la base de datos 'generador'
			$filter_field = $this->verify_field();

			if(empty($_POST["quantityOfRowsFromTable"]))
			{
				header("Location: ".Conectar::ruta()."?accion=fill_column&table=".$_POST['initial_table']."&column=".$_POST['initial_column']."&m=1");
				exit;
			}
			elseif (!ctype_digit($_POST["quantityOfRowsFromTable"]))
			{
				header("Location: ".Conectar::ruta()."?accion=fill_column&table=".$_POST['initial_table']."&column=".$_POST['initial_column']."&m=2");
				exit;
			}
			elseif ($_POST[$column] == 'empty')
			{
				header("Location: ".Conectar::ruta()."?accion=fill_column&table=".$_POST['initial_table']."&column=".$_POST['initial_column']."&m=5");
				exit;
			}
			else
			{
				$quantity = $_POST["quantityOfRowsFromTable"];

				// Recuperando registros de cada campo en 'generador'
				$registros = $this->data_generador($filter_field);

				// Verificando si existen registros en la tabla antes de poblar
				$reg_exist = "select * from ".$_POST['initial_table']." limit 1";
				$query_result = mysql_query($reg_exist, parent::con($database));
				$row = mysql_num_rows($query_result);

				if ($row == 1)
				{
					for ($l=0; $l <= $quantity; $l++)
					{
						$nro_registros = count($registros) - 1;
						$k = mt_rand(0, $nro_registros);
						$dato = $registros[$k][$filter_field];

						$consulta =	"update ".$_POST['initial_table']." set ".$_POST['initial_column']." = '".$dato."' where ".$id." = ".$l;
						mysql_query($consulta, parent::con($database));
					}
				}
				elseif ($row == 0)
				{
					for ($l=0; $l < $quantity; $l++)
					{
						$nro_registros = count($registros) - 1;
						$k = mt_rand(0, $nro_registros);
						$dato = $registros[$k][$filter_field];

						$consulta =	"insert into ".$_POST['initial_table']." (".$_POST['initial_column'].") values ('$dato')";
						mysql_query($consulta, parent::con($database));
					}
				}
				header("Location: ".Conectar::ruta()."?accion=fill_column&table=".$_POST['initial_table']."&column=".$_POST['initial_column']."&m=4");
			}
		}
	}

	public function verify_field()
	{
		if (!isset($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=3");
			exit;
		}
		else
		{
			$arreglo = $_POST;
			$initial_table = $_POST['initial_table'];
			$database = $_SESSION["database"];
			parent::con($database);


			$sql = "SHOW columns FROM " . $initial_table;

			$res = mysql_query($sql);
			while($reg = mysql_fetch_array($res))
			{
				$this->initial_table[]=$reg;
			}

			$field = null;

			for ($j=0; $j < count($this->initial_table); $j++)
			{
				foreach ($arreglo as $key => $value)
				{
					if($this->initial_table[$j]["Field"] == $key)
					{
						return $value;
					}
				}
			}
		}
	}

	public function data_generador($field)
	{
		if (!isset($_SESSION["database"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=3");
			exit;
		}
		else
		{
			parent::con("generador");

			$query = "SHOW TABLES FROM generador";
			$result = mysql_query($query);
			while($registro = mysql_fetch_array($result))
			{
				$this->tabla[]=$registro;
			}
			for ($i = 0; $i < count($this->tabla); $i++)
			{
				$tabla = $this->tabla[$i][0];
				$qry = "select " . $field ." from ".$tabla;
				$r = mysql_query($qry);
				if (!empty($r))
				{
					while($rg = mysql_fetch_array($r))
					{
						$this->datos[]=$rg;
					}
					return $this->datos;
				}
			}
		}
	}
}
?>