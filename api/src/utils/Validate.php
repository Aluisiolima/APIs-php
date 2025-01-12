<?php
    namespace src\utils;

    use Exception;

    class Validate
    {
        public function validate($data)
        {
            if (!is_array($data)) {
                throw new Exception("O validado dever receber um array");
            }

            foreach ($data as $key => $value) {
                if(empty(trim((string) $value))) {
                    throw new Exception("O item { $key } e obrigatorio!!");
                }

                $data[$key] = is_string($value) ? strtolower($value) : $value;
            }
            return $data;
        }
    }