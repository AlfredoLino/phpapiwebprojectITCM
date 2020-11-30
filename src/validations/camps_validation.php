<?php
class Validations{
    /**
     * @param $campos Datos Arreglo asociativo de los datos a validar;
     * @return bool Si pasa o no la validacion
     */
    public static function checkCampsAlumno($campos){
        $defined_keys = array("email", "password");
        $validReq = true;
        /**
         * Iteramos sobre la variavle "definded_keys" para ver si uno falta o está en mal forma.
         */
        foreach($defined_keys as $key){
            if(!isset($campos[$key]) || $campos[$key] == ""){
                $validReq = false;
            }
        }
        return $validReq;
    }

    /**
     * @param $campos Datos Arreglo asociativo de los datos a validar para el profesor
     * @return bool
     */
    public static function checkCampsProfessor($campos){
        $defined_keys = array("email", "password");
        $validReq = true;
        /**
         * Iteramos sobre la variavle "definded_keys" para ver si uno falta o está en mal forma.
         */
        foreach($defined_keys as $key){
            if(!isset($campos[$key]) || $campos[$key] == ""){
                $validReq = false;
            }
        }
        return $validReq;
    }
    /**
     * @param $campos array asociativo con los campos a verificar
     */
    public static function checkAsignacion($campos){
        $defined_keys = array("grupo", "alumno");
        $validReq = true;
        /**
         * Iteramos sobre la variavle "definded_keys" para ver si uno falta o está en mal forma.
         */
        foreach($defined_keys as $key){
            if(!isset($campos[$key]) || $campos[$key] == ""){
                $validReq = false;
            }
        }
        return $validReq;
    }

    public static function checkEmailPatch($campos){
        $defined_keys = array("alumno", "email");
        $validReq = true;
        /**
         * Iteramos sobre la variavle "definded_keys" para ver si uno falta o está en mal forma.
         */
        foreach($defined_keys as $key){
            if(!isset($campos[$key]) || $campos[$key] == ""){
                $validReq = false;
            }
        }
        return $validReq;
    }
};

