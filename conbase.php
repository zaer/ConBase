<?php
#==================================================#
#     coded by: Moises Espindola         _    _    #
#     nick: zaer00t                     | |  (_)   #
#    ___  _ __   ___   __ _  ___   __ _ | |_  _    #
#   / __|| '__| / _ \ / _` |/ __| / _` || __|| |   #
#  | (__ | |   |  __/| (_| |\__ \| (_| || |_ | |   #
#   \___||_|    \___| \__,_||___/ \__,_| \__||_|   #
#                                                  #
#    e-mail: zaer00t@gmail.com                     #
#    www: http://creasati.com.mx                   #
#    date: 23/Octubre/2014                         #
#    code name: chicles pa la banda		   #
#    version: 0.1 (obsoleta)       		   #
#==================================================#

    class db
    {
        private $dbhost;
        private $dbuser;
        private $dbpass;
        private $dbname;
        private $conn;
        
        //En el constructor de la clase establecemos los parámetros de conexión con la base de datos
        
        function __construct($dbuser = 'root', $dbpass = '', $dbname = 'conta', $dbhost = 'localhost')
        {
            $this->dbhost = $dbhost;
            $this->dbuser = $dbuser;
            $this->dbpass = $dbpass;
            $this->dbname = $dbname;
        }
        
        //El método abrir establece una conexión con la base de datos
        public function abrir()
        {
            $this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass,$this->dbname);
            if (mysqli_connect_errno())
            {
                die('Error al conectar con mysql');
            }
        }
        
        /*
         *  El método "consulta" ejecuta la sentencia select que recibe por parámetro "$query"
         *  a la base de datos y devuelve un array asociativo con los datos que obtuvo de la
         *  base de datos para facilitar su manejo con foreach y no perder la costumbre con mysql_fetch_array  XD
         */
        
        public function consulta($query)
        {
            $valores = array();
            $result = mysqli_query($this->conn,$query);
            if (!$result)
            {
                die('Error query BD:' . mysqli_error());
            }
            else
            {
                $num_rows= mysqli_num_rows($result);
                for($i=0;$i<$num_rows;$i++)
                {
                    $row = mysqli_fetch_assoc($result);
                    array_push($valores, $row);
                }
            }
            return $valores;
        }
        
        /*
         * La función sql nos permite ejecutar una senetencia sql en la base de
         * datos, se suele utilizar para senetencias insert y update.
         */
        
        public function sql($sql)
        {
            $resultado=mysqli_query($this->conn,$sql);
            return $resultado;
        }
        
        /*
         *  La función id nos devuelve el identificador del último registro
         *  insertado en la base de datos
         */
        
        public function id()
        {
            return mysqli_insert_id($this->conn);
        }
        
        /*
         *  La función "cerrar" finaliza la conexión con la base de datos.
         *  de preferencia al final de cada archivo php que cree una conexion
         */
        
        public function cerrar()
        {
            mysqli_close($this->conn);
        }
    }
    
    /* como utilizar */
    $data = new db(); //creamos el objeto
    $data->abrir(); //abrimos la conexion a mysql
    
    $consulta = "select * from users";  //consulta simple
    $datos = $data->consulta($consulta);    //generamos la consulta
    
    echo "<pre>";
    print_r($datos);
    echo "</pre>";
    
?>
