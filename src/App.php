<?php
/**
 * Description of App
 *
 * @author igs03102
 * @entity @Table(name="applications")
 */
class App {

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
     *
     * @var string
     * @Column(type="string")
     */
    protected $path;
    
    /**
     *
     * @var string
     * @Column(type="string")
     */
    protected $panelimage;
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getPath() {
        return $this->path;
    }
    public function setPath($path) {
        $this->path = $path;
    }
    
    public function getPanelImage() {
        return $this->panelimage;
    }
    public function setPanelImage($path) {
        $this->panelimage = $path;
    }

}
