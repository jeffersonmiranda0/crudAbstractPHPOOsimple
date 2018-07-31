<?php
class ReturnService {
    
    /**
     * METODO RESPONSAVEL APENAS POR RETORNAR PADRAO DE REQUEST
     * @param type $message
     * @param type $status
     * @param type $request
     * @return type
     */
    public static function requestStatus($message, $status = true, $request = [])
    {
        return [
            'status'    => $status,
            'message'   => $message,
            'request'   => $request
        ];
    }
    
}
