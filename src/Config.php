<?php
/**
 * Description of Config
 *
 * @author igs03102
 * @entity @Table(name="config")
 */
class Config {

    /**
     *
     * @var int
     * @Id 
     * @Column(type="integer") 
     * @GeneratedValue
     */
    protected $id;
    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     *@var string
     *@Column(type="string")
     */
    protected $value;   


    /**
     *@var string
     *@column(type="string")
     */
    protected $path;
    function getPath() {
       return $this->path;
    }

    function setPath($path) {
	$this->path = $path;
    }

    function getId() {
	return $this->id;
    }
  function getName() {
	return $this->name;
    }
    function setName($name) {
        $this->name = $name;
    }

    function getValue() {
        return $this->value;
    }

    function setValue($value) {
        $this->value = $value;
    }
}
