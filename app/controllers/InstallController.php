<?php

use Schema, Config;
use October\Rain\Config\ConfigWriter;
use Cupboard\Core\Repositories\UserRepositoryInterface;

class InstallController extends Controller {

	/**
	 * The user repository implementation.
	 *
	 * @var Cupboard\UserRepositoryInterface
	 */
	protected $users;

        /**
         * @var October\Rain\Config\ConfigWriter
         */
        protected $configWriter;

	/**
	 * Create a new API User controller.
	 *
	 * @param UserRepositoryInterface $users
	 *
	 * @internal param UserRepositoryInterface $user
	 * @return InstallController
	 */
	public function __construct(UserRepositoryInterface $users)
	{
		$presence = Validator::getPresenceVerifier();
		$presence->setConnection('cupboard');

		$this->users = $users;
                $this->configWriter = new ConfigWriter;
	}

	/**
	 * Get the install index.
	 *
	 * @return Response
	 */
	public function start()
	{
                 // If the config is marked as installed then bail with a 404.
                 if (Schema::hasTable('services'))
                 {
                        return App::abort(404, 'Page not found');
                 }
                 else
                        return View::make('admin.installer.step1');
	}

	/**
	 * Run the migrations
	 *
	 * @return Response
	 */
	public function publishAndMigrate()
	{
                define('STDIN',fopen("php://stdin","r"));

		$artisan = Artisan::call(
			'migrate',
			array(
				'--force' => true,
                                '--env' => App::environment(),
				'--database' => 'cupboard',
				'--package' => 'cupboard/core'
			)
		);

		Artisan::call(
			'asset:publish',
			array('package' => 'cupboard/core')
		);

		if ($artisan > 0)
		{
			return Redirect::back()
				->withErrors(array('error' => 'Install Failed'))
				->with('install_errors', true);
		}

		return Redirect::to('install/user');
	}

	/**
	 * Get the user form.
	 *
	 * @return Response
	 */
	public function createUser()
	{
                 $installed = DB::table('services')->where('feature', 'installed')->pluck('enabled');
                 if ($installed)
                 {
                        return App::abort(404, 'Page not found');
                 }
                 else
		        return View::make('admin.installer.user');
	}

	/**
	 * Add the user and show success!
	 *
	 * @return Response
	 */
	public function storeUser()
	{
		$messages = $this->users->validForCreation(
			Input::get('first_name'),
			Input::get('last_name'),
			Input::get('email'),
			Input::get('password')
		);

		if (count($messages) > 0)
		{
			return Redirect::back()
				->withErrors($messages)
				->with('install_errors', true);
		}

		$user = $this->users->create(
			Input::get('first_name'),
			Input::get('last_name'),
			Input::get('email'),
			1, // Force them as active
			Input::get('password')
		);

		return Redirect::to('install/config');
	}

	/**
	 * Get the config form.
	 */
	public function editConfig()
	{

                 $installed = DB::table('services')->where('feature', 'installed')->pluck('enabled');
                 if ($installed)
                 {
                        return App::abort(404, 'Page not found');
                 }
                 else
		        return View::make('admin.installer.config');
	}

	/**
	 * Save the config files
	 */
	public function updateConfig()
	{
                define('STDIN',fopen("php://stdin","r"));
		$this->setCupboardConfig(
			Input::get('title', 'Site Name'),
			Input::get('theme', 'Default'),
			Input::get('per_page', 5)
		);

                Cache::add('cupboard.installed', 'true', 60);

                DB::table('services')->insert(
			array(
                          'id'=>'1',
			  'feature'=>'installed',
			  'enabled'=>'1')
                        );

                return View::make('admin.installer.complete');
	}

	/**
	 * Update the configs based on passed data
	 *
	 * @param string $title
	 * @param string $theme
	 * @param int    $per_page
	 *
	 * @return
	 */
	protected function setCupboardConfig($title, $theme, $per_page)
	{
		$path = $this->getConfigFile('cupboard');
		
                $this->writeToConfig('cupboard', ['title' => addslashes($title)]);
                $this->writeToConfig('cupboard', ['theme' => $theme]);
                $this->writeToConfig('cupboard', ['per_page' => (int) $per_page]);
                $this->writeToConfig('cupboard', ['installed' => true]);

	}


        protected function writeToConfig($file, $values)
        {
                $configFile = $this->getConfigFile($file);
                foreach ($values as $key => $value) {
                    Config::set($file.'.'.$key, $value);
                }
                
                $this->configWriter->toFile($configFile, $values);
        }


	/**
	 * Get the config file
	 *
	 * Use the current environment to load the config file. With a fall back on the original.
	 *
	 * @param string $file
	 * @return string
	 */
	protected function getConfigFile($name = 'cupboard')
	{
                $name .= '.php';
		if (file_exists(app_path().'/config/packages/cupboard/core/'.App::environment().'/'.$name))
		{
			return app_path().'/config/packages/cupboard/core/'.App::environment().'/'.$name;
		}

		return app_path().'/config/packages/cupboard/core/'.$name;
	}
}
