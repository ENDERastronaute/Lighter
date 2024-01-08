<?php
    namespace Repository;
    use Model\Response;
    use Database\Db;

    abstract class Repository
    {
        protected $data = array();

        protected $attributes = array();
        protected $attributes_labels = array();

        protected $table;

        protected $name;

        public function __construct(array $attributes, array $attributes_labels, string $table, string $name)
        {
            $this->attributes = $attributes;
            $this->attributes_labels = $attributes_labels;
            $this->table = $table;
            $this->name = $name;
        }
        
        public function validateData($data, $action = 'add') : Response
        {
            $response = new Response(true, 'Les données sont valides');
    
            foreach($this->attributes as $attribute => $rules)
            {
                $rulesArray = explode(';', $rules);

                foreach($rulesArray as $rule)
                {
                    if($rule === 'required')
                    {
                        if(!isset($data[$attribute]))
                        { // Check si la donnée est remplie
                            $response->set_success(false);
                            $response->set_message( "1. L'attribute " . $this->attributes_labels[$attribute] . ' est obligatoire');

                            break;
                        }

                        elseif(trim($data[$attribute]) === '')
                        { // Check si elle est différente d'un string vide
                            $response->set_success(false);
                            $response->set_message( "2. L'attribute " . $this->attributes_labels[$attribute] . ' est obligatoire');

                            break;
                        }
                    }

                    else if($rule === 'unique')
                    {
                        $person = $this->get_by_attribute($attribute, $data[$attribute]);
    
                        if($action === 'edit')
                        {
    
                            if($person->getId() != $_POST['id'])
                            {     
                                $response->set_success(false);
                                $response->set_message( "3. L'attribute " . $this->attributes_labels[$attribute] . ' doit être unique, il existe déjà');
                                
                                break;
                            }
    
                        }
                        elseif($person)
                        {
                            $response->set_success(false);
                            $response->set_message( "3. L'attribute " . $this->attributes_labels[$attribute] . ' doit être unique, il existe déjà');
                            
                            break;
                        }
                    }
                }
            }
        
            return $response;
        }

        public function get_by_id(int $id)
        {
            foreach ($this->data as $element)
            {
                if($element->getId() == $id)
                {
                    return $element;
                }
            }
            
            return null;
        }

        public function get_by_attribute(string $attribute, $value)
        {
            foreach ($this->data as $data)
            {
                if($data->get($attribute) == $value)
                {
                    return $data;
                }
            }

            return null;
        }

        public function delete(int $id, Repository $repository)
        {
            $client = Db::connect();

            $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

            $stmt = $client->prepare($sql);
            $stmt->execute([$id]);

            $repository->load_data();

            return new Response(true, 'La ' . $this->name . ' a été supprimé(e)');
        }

        public function get_data() {
            return $this->data;
        }

        abstract public function load_data();
    }
?>