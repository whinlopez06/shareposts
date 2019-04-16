<?php 

class Validate {

    private $_passed = false;
    private $_errors = array();
    private $_db = null;

    public function __construct()
    {
        $this->_db = new Database();
    }

    public function check($source, $items = array()){

        foreach($items as $item => $rules){
            foreach($rules as $rule => $rule_value){
                $value = trim($source[$item]);

                $Item = htmlentities($item);
                if($rule === 'required' && empty($value)) {
					$this->addError(array($item . '_err' => "{$item} is required"));
				}elseif(!empty($value)){

                    switch($rule) {
						case "min":		// this is the rule
							if(strlen($value) < $rule_value) {
								$this->addError(array($item . '_err'=> "{$item} must be a minimum of {$rule_value} characters."));
							}
						break;
						case "max":
							if(strlen($value) > $rule_value) {
								$this->addError(array($item . '_err' => "{$item} must be a maximum of {$rule_value} characters."));
							}
						break;
						case "matches":
							// the value of password_again must be equal to source arr[password]
							if($value != $source[$rule_value]) {
								$this->addError(array($item . '_err' => "{$rule_value} must match {$item}"));	
							}
						break;
						case "unique":
												   // table name,  =,  current value from post/textbox
                            $check = $this->_db->get($rule_value, array($item,'=', $value));
                            
							if($check->rowCount()) {
								$this->addError(array($item . '_err' => "{$item} already exists."));	// item already exist 	
							}
                        break;
                        case "exists":
                           
                            $check = $this->_db->get($rule_value, array($item,'=', $value));

                            if($check->rowCount() < 1) {
                                $this->addError(array($item . '_err' => "{$item} not found."));	// item already exist 	
                            }
                        break;
					}

                }
            }
        }

        //print_r($this->errors()); die('....');
        if(empty($this->_errors)) {
			$this->_passed = true;		// not errors found. passed is always default to false
		} 

        return $this;   // return instance of this class
    }

    public function addError($error){
        $this->_errors[] = $error;
    }

    public function errors(){
        return $this->_errors;
    }

    public function passed(){
        return $this->_passed;
    }

}


?>