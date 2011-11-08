<?php

/* 
 * Created by TIgor
 * e-mail: tigorr@gmail.com
 * site: multul.ru
 */

class p_multul extends cmsPlugin {
// ==================================================================== //

    public function __construct(){
		
        parent::__construct();
		
		// Информация о плагине
        $this->info['plugin']           = 'p_multul';
        $this->info['title']            = 'Мессенджер Multul';
        $this->info['description']      = 'Личные сообщения';
        $this->info['author']           = 'TIgor';
        $this->info['version']          = '1.0';
		
		// События, которые будут отлавливаться плагином
        $this->events[]                 = 'PRINT_PAGE_BODY';
		
		// Настройки по-умолчанию
		$this->config['app_id']	= 0; // ID приложения
		$this->config['v']	= 1;
		$this->config['secret_key']	= ''; // Секретный ключ приложения
	}
	
// ==================================================================== //

    /**
     * Процедура установки плагина
     * @return bool
     */
    public function install(){
        return parent::install();
    }
	
// ==================================================================== //

    /**
     * Процедура обновления плагина
     * @return bool
     */
    public function upgrade(){
          return parent::upgrade();
    }
	
// ==================================================================== //

    /**
     * Обработка событий
     * @param string $event
     * @param mixed $item
     * @return html
     */
	 
    public function execute($event, $item){
        parent::execute();
		
		$inUser = cmsUser::getInstance();

		// Если плагин установлен
		if ($inUser->id > 0 && $this->config['app_id'] > 0) {

			// Подключение библиотеки
			$this->inCore->includeFile('plugins/p_multul/multul.php');

			// Настройка приложения
			$config = array(
				'app_id'	=> $this->config['app_id'],
				'secret_key'=> $this->config['secret_key'],
				'v'			=> $this->config['v'],
				'uid'		=> $inUser->id,
				'name'		=>  iconv('WINDOWS-1251//IGNORE', 'UTF-8//IGNORE', $inUser->nickname),
			);
			// Получение HTML кода для вставки
			echo Multul::factory($config)->render();
		}
        return $item;
    }

// ==================================================================== //

}