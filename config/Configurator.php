<?php
class Configurator {

    private $config;

    public function __construct()
    {
       /* $this->config = parse_ini_file("config/config.ini");*/
       $this->config = parse_ini_file(__DIR__ . "/config.ini", true);

    }

    public function getUsuarioController()
    {
        return new UsuarioController($this->getUsuarioModel(),$this->getRenderer(), new Request());
    }
    public function getRankingController()
    {
        return new RankingController($this->getUsuarioModel(),$this->getRankingModel(),$this->getRenderer(), new Request());
    }
    private function getDatabase()
    {
        $dbConfig = $this->config['database'];
        return new MyDatabase(
            $dbConfig['hostname'],
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['database']
        );
    }

    private function getRenderer()
    {
        return new MustacheRenderer(__DIR__ . '/../view', $this->getUsuarioModel() );
    }


    private function getUsuarioModel()
    {
        return new UsuarioModel($this->getDatabase());
    }

    private function getPreguntaModel()
    {
        return new PreguntaModel($this->getDatabase());
    }
    private function getRankingModel()
    {
        return new RankingModel($this->getDatabase());
    }
    private function getTrampitasModel()
    {
        return new TrampitasModel($this->getDatabase());
    }
    private function getPartidaModel()
    {
        return new PartidaModel($this->getDatabase());
    }

    public function getRouter()
    {
        return new Router($this, 'home', 'irAlHome');
    }

    public function getOrDefault($controllerName, $defaultControllerName)
    {
        $getter = 'get' . ucfirst($controllerName) . 'Controller';
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }
        $defaultGetter = 'get' . ucfirst($defaultControllerName) . 'Controller';
        return $this->{$defaultGetter}();
    }
    public function getHomeController()
    {
        return new HomeController($this->getRenderer());
    }
    public function getLobbyController()
    {
        return new LobbyController($this->getUsuarioModel(),$this->getRenderer(),$this->getRankingModel());
    }
    public function getPreguntaController()
    {
        return new PreguntaController($this->getPreguntaModel(),$this->getRenderer());
    }
    public function getLoginController() {
        return new LoginController($this->getUsuarioModel(), $this->getRenderer(), new Request());
    }
    public function getTrampitasController() {

        return new TrampitasController($this->getUsuarioModel(), $this->getRenderer(), new Request(), $this->getTrampitasModel());
    }
    public function getPartidaController() {
        return new PartidaController($this->getPreguntaModel(),$this->getPartidaModel() ,$this->getRenderer(), new Request());
    }
    public function getEditorController()
    {
        return new EditorController($this->getPreguntaModel(),$this->getRenderer(), new Request());

    }
    public function getAdminController() {

    return new AdminController( $this->getUsuarioModel(),$this->getPartidaModel(), $this->getPreguntaModel(), $this->getRenderer(), new Request());

    }
}





