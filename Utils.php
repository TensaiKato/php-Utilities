<?php
/**
Class with Util functions to help in most of common daily needs
Content:
  - Array of WeekDays (in Portuguese);
  - Array of Months(in Portuguese);
  - Array of MonthsShort (in Portuguese);
  - Array of Brazilian States;
  - Array of Marital status (in Portuguese);
  - Array of Genders (in Potuguese);
  - Function to Revome Accents and Spaces - RemoveSpacesAndAccents();
  - Function to trim a text and add "..." in the end - TrimText();
  - Function to sanitate a string from HTML tags - HTMLDecode();
  - Function to validade an e-mail - IsEmail();
  - Function to generate a random string - GenerateRandomString();
  - Function to preprare a double field from Database to show in BRL currency - ValuetoShow();
  - Function to prepare an user field to be saved in a double type field database - ValuetoSave();
  - Function to transform and check a date to persistition - DatetoSave();
  - Function to transform a datetime field from database into BR date format - DatetoShow();
  - Function to sanitate a string for letters an numbers or one another only - StripSpecialChars();
  - Function to handle messages to the user - SetMessage();
  - Function to show and delete the message afterwards - GetMessage();
  - Function to generate a hidden input inside a form - GenerateFormKey()
  - Function to check when having multiple forms - ValidateFormKey();
  - Function to only return numbers from a string - OnlyNumbers();
  - Function to get an array of days by a givem month- getDaysbyMonth();
  - Function to return the last day o a certain month - getLastDaybyMonth();
  - Function to Mask a string - Mask();
  - Function to generate a string in month name / Year given a YYYYMM - ShowMonthYear();
  - Function to write a number in extended string - NumberToWriting();
  - Function to add business hours (8AM - 6PM) - AddBusinessHours();
  - Functions to doce/decore in Base64 a string - Encrypt()/Decrypt();
  - Functin to create/check a safe password using PASSWORD_ARGON2ID - MakePassword()/CheckPassword().
  
  **/
Class Utils {


    /**
     * Dynamic type list for Week Days
     *
     * @var array
     */
    public static $WeekDays = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');

    /**
     * Dynamic type list for Month names
     *
     * @var array
     */
    public static $Months = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');


    /**
     * Dynamic type list for short Month names
     *
     * @var array
     */
    public static $MonthsShort = array('', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');


    /**
     * Dynamic type list for States built by SIGLA => NOME
     *
     * @var array
     */
    public static $States = array('AC' => 'Acre', 'AL' => 'Alagoas', 'AM' => 'Amazonas', 'AP' => 'Amapá', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás',
        'MA' => 'Maranhão', 'MG' => 'Minas Gerais', 'MS' => 'Mato Grosso do Sul', 'MT' => 'Mato Grosso', 'PA' => 'Pará', 'PB' => 'Paraiba', 'PE' => 'Pernambuco', 'PI' => 'Piaui', 'PR' => 'Paraná', 'RJ' =>
            'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'RS' => 'Rio Grande do Sul', 'SC' => 'Santa Catarina', 'SE' => 'Sergipe', 'SP' => 'São Paulo', 'TO' => 'Tocantins');

  /**
   * Dynamic type list for marital status
   *
   * @var array
   */
    public static $EstadoCivil = array(
            '1' => 'Solteiro',
            '2' => 'Casado',
            '3' => 'Separado',
            '4' => 'Divorciado',
            '5' => 'Viúvo'
  );
  /**
   * Dynamic type list for gender
   *
   * @var array
   */
    public static $Sexos = array(
          'F' => 'Feminino',
          'M' => 'Masculino',
          'N' => 'Não Informar'
    );

    /**
     * Function to remove accents or spaces from a string
     *
     * @param string $str text
     * @param bool $toarray to remove ' ' and '/'
     * @poaram bool $onlyspaces flag to remove only spaces
     *
     * @return string from strstr.
     */
    public static function RemoveSpacesAndAccents($str, $toarray = false, $onlyspaces = false) {
        if($onlyspaces) {
            if ($toarray) {
                $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç /';
                $to = 'AAAAEEIOOOUUCaaaaeeiooouuc_-';
            } else {
                $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
                $to = 'AAAAEEIOOOUUCaaaaeeiooouuc';
            }
        } else {
            $from = '_';
            $to   = ' ';
        }
        return strtr($str, $from, $to);
    }

    /**
     * Function to Trim the text with a delimited lenght
     *
     * @param string $string text
     * @param int $caracter amount
     *
     * @return string
     */
    function TrimText($string, $caracter) {
        $string = strip_tags(Utils::HTMLDecode($string));

        if (strlen($string) > $caracter)
        {
            $string = substr($string, 0, $caracter) . "...";
        }

        return $string;
    }

    /**
     * Function to Strip HTML tags from a string
     *
     * @param string $s text
     *
     * @return string
     */
    private static function HTMLDecode($s) {
        return html_entity_decode(html_entity_decode($s));
    }

    /**
     * Function to validate if the string is an email
     *
     * @param string $s text
     *
     * @return string
     */
    public static function IsEmail($s){
        return filter_var($s, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Function to generate a random string
     *
     * @param int $l length
     *
     * @return string
     */
    public static function GenerateRandomString($l = 10) {
        if(!is_int($l)) return false;

        $str = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $size = strlen( $chars );
        for( $i = 0; $i < $l; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }

    /**
     * Function to transform the value to be shown to the user as decimal ',' and thousand '.'
     *
     * @param double $v value
     *
     * @return double
     */
    public static function ValuetoShow($v) {
        return number_format($v, 2, ',', '.');
    }

    /**
     * Function to transform the value in the input as a proper double
     * to be stored in the database as decimal '.' and thousand ''
     *
     * @param double $v value
     *
     * @return string
     */
    public static function ValuetoSave($v) {
        return str_replace(",", ".", str_replace(".", "", str_replace("R$ ", "", $v)));
    }

    /**
     * Function to transform the input date dd/mm/yyyy | H:i:s
     * into the database collation YYYY-mm-dd H:i:s
     *
     * @param string $d date
     *
     * @return string
     */
    public static function DatetoSave($d, $time = false) {
      if(!$time) {
        $dateObj = DateTime::createFromFormat("d/m/Y", $d);
        if (!$dateObj) return false;
        $ret = $dateObj->format("Y-m-d");
      } else {
        $dateObj = DateTime::createFromFormat("d/m/Y H:i:s", $d);
        if (!$dateObj) return false;
        $ret = $dateObj->format("Y-m-d H:i:s");
      }
      return $ret;
    }

    /**
     * Function to transform the input date yyyy-mm-dd | H:i:s
     * into the database collation dd/mm/yyyy H:i:s
     *
     * @param string $d date
     *
     * @return string
     */
    public static function DatetoShow($d, $time = false) {
      if(!$time) {
        $dateObj = DateTime::createFromFormat("Y-m-d", $d);
        if (!$dateObj) return false;
        $ret = $dateObj->format("d/m/Y");
      } else {
        $dateObj = DateTime::createFromFormat("Y-m-d H:i:s", $d);
        if (!$dateObj) return false;
        $ret = $dateObj->format("d/m/Y H:i:s");
      }
      return $ret;
    }

    /**
     * Function to sanitate a string leaving only letters and numbers
     *
     * @param string $s string
     *
     * @return string
     */
    public static function StripSpecialChars($s, $flag = false) {
      if(!$flag) {
        return preg_replace("/[^a-zA-Z0-9]/", "", $s);
      } else if(is_int($flag)) {
        return preg_replace("/[^0-9]/", "", $s);
      } else {
        return preg_replace("/[^a-zA-Z]/", "", $s);
      }

    }

    /**
     * Function to register a SESSION with a desired message
     *
     * @param string $tipo type
     * @param string $mensagem message
     * @param string $titulo title
     */
    public static function SetMessage($tipo, $mensagem = "", $titulo = "") {

        $_SESSION["BoxMensagem"] = ((!$_SESSION["BoxMensagem"]) ? array() : $_SESSION["BoxMensagem"]);
        $_SESSION["BoxMensagem"][] = array("Titulo" => $titulo, "Mensagem" => $mensagem, "Tipo" => $tipo);
    }

    /**
     * Function to retrieve a message stroed into
     * the SESSION and delete it afterwards
     *
     */
    public static function GetMessage() {

        if (!is_array($_SESSION["BoxMensagem"]))
        {
            return false;
        }


        foreach($_SESSION["BoxMensagem"] as $c => $v)
        {
            $titulo = $v["Titulo"];
            $msg = $v["Mensagem"];
            $tipo = $v["Tipo"];

            $mensagem = array();

            // erro
            $mensagem["Erro"] = array();
            $mensagem["Erro"]["Titulo"] = "Erro!";
            $mensagem["Erro"]["Class"] = "danger";
            $mensagem["Erro"]["Mensagem"] = "Ocorreu um erro durante esse processo!";

            // Remover
            $mensagem["Remover"] = array();
            $mensagem["Remover"]["Titulo"] = "Confirmado!";
            $mensagem["Remover"]["Class"] = "warning";
            $mensagem["Remover"]["Mensagem"] = "O <b>Registro</b> foi removido com sucesso!";

            // Editar
            $mensagem["Editar"] = array();
            $mensagem["Editar"]["Titulo"] = "Sucesso!";
            $mensagem["Editar"]["Class"] = "info";
            $mensagem["Editar"]["Mensagem"] = "<b>Registro</b> editado com sucesso!";

            // Cadastrar
            $mensagem["Cadastrar"] = array();
            $mensagem["Cadastrar"]["Titulo"] = "Sucesso!";
            $mensagem["Cadastrar"]["Class"] = "success";
            $mensagem["Cadastrar"]["Mensagem"] = "<b>Registro</b> gravado com sucesso!";

            // erro
            $mensagem["Arquivo"] = array();
            $mensagem["Arquivo"]["Titulo"] = "Ocorreu um erro durante esse processo! Arquivo inválido!";
            $mensagem["Arquivo"]["Class"] = "danger";
            $mensagem["Arquivo"]["Mensagem"] = "";


            if (!$titulo)
            {
                $titulo = $mensagem[$tipo]["Titulo"];
            }

            if (!$msg)
            {
                $msg = $mensagem[$tipo]["Mensagem"];
            }

            echo '<div class="alert alert-' . $mensagem[$tipo]["Class"]. ' alert-dismissible fade show" role="alert">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button"><span aria-hidden="true"> x</span></button>
                    <strong><i class="os-icon os-icon-bell"></i>' . $titulo .'</strong> ' . $msg . '
                    </div>';
        }

        unset($_SESSION["BoxMensagem"] );
        return true;
    }

    /**
     * Function to generate a hidden input to control the
     * form submition
     *
     * @param string $name name
     *
     * @return string
     */
    public static function GenerateFormKey($name = "") {
        $chave = Utils::GenerateRandomString(20);
        $_SESSION["FormChave" . $name] = $chave;
        return '<input type="hidden" id="hidFormChave' . $name . '" name="hidFormChave' . $name . '" value="' . $chave . '" />';
    }

    /**
     * Function to validate the generated Key for a form
     *
     * @param string $Method method
     * @param string $name name
     *
     */
    public static function ValidateFormKey($Method, $name = "") {

        if($Method["hidFormChave" . $name])
        {
            if($Method && $Method["hidFormChave" . $name] == $_SESSION["FormChave" . $name])
            {
                unset($_SESSION["FormChave" . $name]);
                return true;
            }
        }

        return false;
    }

    /**
     * Function that strip any non digit character from a string
     *
     * @param string $str string
     *
     * @return string
     */
    public static function OnlyNumbers($str) {
        return preg_replace('/\D/', '', $str);
    }

    /**
     * Function that return an array with all days by a desired month
     *
     * @param int $m month
     *
     * @return array
     */
    public static function getDaysbyMonth($m) {
        $d = array();
        switch ($m) {
            case 2:{
                for($i=1;$i<29;$i++) {
                    $d[] = $i;
                }
                return $d;
            } break;

            case 1: case 3: case 5: case 7: case 8: case 10: case 12: {
                for($i=1;$i<32;$i++) {
                    $d[] = $i;
                }
                return $d;
            } break;
            case 4: case 6: case 9: case 11:{
                for($i=1;$i<31;$i++) {
                    $d[] = $i;
                }
                return $d;
            } break;


        }
    }

    /**
     * Function that return the last day for a month
     *
     * @param int $m month
     *
     * @return int
     */
    public static function getLastDaybyMonth($m) {
        return count(Utils::getDaysbyMonth($m));
    }

    /**
     * Function that masks a string
     *
     * @param string $val Text
     * @param string $mask Mask
     *
     * @return string
     */
    public static function Mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else{
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    /**
     * Function that generates a string with the Month Name / Year
     *
     * @param string $data Text (Pattern: YYYYMM)
     * @param bool $min whether the year is 2 or 4 digit
     *
     * @return string
     */
    public static function ShowMonthYear($data,$min = false) {
        if(strlen($data) < 6) return;

        return Utils::mesS[intval(substr($data,-2))] . "/" . (($min) ? substr($data,2,2) : substr($data,0,4));
    }

    /**
     * Function that writes the number by extend string
     *
     * @param int $number Number
     *
     * @return string
     */
    public static function NumberToWriting($number) {

        $hyphen      = '-';
        $conjunction = ' e ';
        $separator   = ', ';
        $negative    = 'menos ';
        $decimal     = ' ponto ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'um',
            2                   => 'dois',
            3                   => 'três',
            4                   => 'quatro',
            5                   => 'cinco',
            6                   => 'seis',
            7                   => 'sete',
            8                   => 'oito',
            9                   => 'nove',
            10                  => 'dez',
            11                  => 'onze',
            12                  => 'doze',
            13                  => 'treze',
            14                  => 'quatorze',
            15                  => 'quinze',
            16                  => 'dezesseis',
            17                  => 'dezessete',
            18                  => 'dezoito',
            19                  => 'dezenove',
            20                  => 'vinte',
            30                  => 'trinta',
            40                  => 'quarenta',
            50                  => 'cinquenta',
            60                  => 'sessenta',
            70                  => 'setenta',
            80                  => 'oitenta',
            90                  => 'noventa',
            100                 => 'cento',
            200                 => 'duzentos',
            300                 => 'trezentos',
            400                 => 'quatrocentos',
            500                 => 'quinhentos',
            600                 => 'seiscentos',
            700                 => 'setecentos',
            800                 => 'oitocentos',
            900                 => 'novecentos',
            1000                => 'mil',
            1000000             => array('milhão', 'milhões'),
            1000000000          => array('bilhão', 'bilhões'),
            1000000000000       => array('trilhão', 'trilhões'),
            1000000000000000    => array('quatrilhão', 'quatrilhões'),
            1000000000000000000 => array('quinquilhão', 'quinquilhões')
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words só aceita números entre ' . PHP_INT_MAX . ' à ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Utils::NumberToWriting(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $conjunction . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = floor($number / 100)*100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds];
                if ($remainder) {
                    $string .= $conjunction . Utils::NumberToWriting($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                if ($baseUnit == 1000) {
                    $string = Utils::NumberToWriting($numBaseUnits) . ' ' . $dictionary[1000];
                } elseif ($numBaseUnits == 1) {
                    $string = Utils::NumberToWriting($numBaseUnits) . ' ' . $dictionary[$baseUnit][0];
                } else {
                    $string = Utils::NumberToWriting($numBaseUnits) . ' ' . $dictionary[$baseUnit][1];
                }
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Utils::NumberToWriting($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    /**
     * Function that adds X amount of hours to a given date
     * by only according the 8AM - 6PM weekdays and no weekends
     *
     * @param date $givenDate Date
     * @param int $hours Hours to add
     * @param string $pattern Pattern
     *
     * @return date
     */
    public static function AddBusinessHours($givenDate, $hours, $pattern = "d/m/Y H:i:s"){
        $range = (ceil($hours/7)*120);
        $cnt=1;
        $days = array();
        $goodhours = array();
        $days[] = date("Y-m-d", strtotime($givenDate));
        foreach(range(1,$range) as $num):

            $datetime = date("Y-m-d H:i:s", strtotime('+'.$num.' hour',strtotime($givenDate)));
            $date = date("Y-m-d", strtotime('+'.$num.' hour',strtotime($givenDate)));
            $time = date("Hi", strtotime('+'.$num.' hour',strtotime($givenDate)));
            $day = date("D", strtotime('+'.$num.' hour', strtotime($givenDate)));
            if($day != 'Sat' && $day != 'Sun' && $time >= 800 && $time <= 1800):

                if(!in_array($date, $days)){
                    $days[] = $date;
                }else{
                    $goodhours[$cnt] = $datetime;

                    if($cnt >= $hours && array_key_exists($hours,$goodhours)):
                        return date($pattern, strtotime($goodhours[$hours]));
                        break;
                    endif;

                    $cnt++;
                }
            endif;

        endforeach;
    }

    /**
     * Function to Encrypt in base64 a string
     *
     * @param string $string Text
     *
     * @return Text
     */
    public static function Encrypt($string) {
        return base64_encode($string);
    }

    /**
     * Function to Decrypt in base64 a string
     *
     * @param string $string Text
     *
     * @return Text
     */
    public static function Decrypt($string) {
        return base64_decode($string);
    }

    /**
     * Function to hash a password using PASSWORD_ARGON2ID
     *
     * @param string $password Text
     *
     * @return Text
     */
    public static function MakePassword($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    /**
     * Function to check if a typed password is right
     *
     * @param string $typed_password Text
     * @param string $hash Text
     *
     * @return Bool
     */
    public static function CheckPassword($typed_password, $hash) {
        return password_verify($typed_password, $hash);
    }
}
