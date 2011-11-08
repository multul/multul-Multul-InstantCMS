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
		
		// ���������� � �������
        $this->info['plugin']           = 'p_multul';
        $this->info['title']            = '���������� Multul';
        $this->info['description']      = '������ ���������';
        $this->info['author']           = 'TIgor';
        $this->info['version']          = '1.0';
		
		// �������, ������� ����� ������������� ��������
        $this->events[]                 = 'PRINT_PAGE_BODY';
		
		// ��������� ��-���������
		$this->config['app_id']	= 0; // ID ����������
		$this->config['v']	= 1;
		$this->config['secret_key']	= ''; // ��������� ���� ����������
	}
	
// ==================================================================== //

    /**
     * ��������� ��������� �������
     * @return bool
     */
    public function install(){
        return parent::install();
    }
	
// ==================================================================== //

    /**
     * ��������� ���������� �������
     * @return bool
     */
    public function upgrade(){
          return parent::upgrade();
    }
	
// ==================================================================== //

    /**
     * ��������� �������
     * @param string $event
     * @param mixed $item
     * @return html
     */
	 
    public function execute($event, $item){
        parent::execute();
		
		$inUser = cmsUser::getInstance();

		// ���� ������ ����������
		if ($inUser->id > 0 && $this->config['app_id'] > 0) {

			// ����������� ����������
			$this->inCore->includeFile('plugins/p_multul/multul.php');

			// ��������� ����������
			$config = array(
				'app_id'	=> $this->config['app_id'],
				'secret_key'=> $this->config['secret_key'],
				'v'			=> $this->config['v'],
				'uid'		=> $inUser->id,
				'name'		=>  iconv('WINDOWS-1251//IGNORE', 'UTF-8//IGNORE', $inUser->nickname),
			);
			// ��������� HTML ���� ��� �������
			echo Multul::factory($config)->render();
		}
        return $item;
    }

// ==================================================================== //

}