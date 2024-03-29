<?php

/**
 * @license MIT, http://opensource.org/licenses/MIT
 * @copyright Aimeos (aimeos.org), 2015-2016
 * @package laravel
 * @subpackage Controller
 */


namespace Aimeos\Shop\Controller;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * Aimeos controller for the JQuery admin interface
 *
 * @package laravel
 * @subpackage Controller
 */
class JqadmController extends AdminController
{
	use AuthorizesRequests;




	/**
	 * Returns the HTML code for batch operations on a resource object
	 *
	 * @return string Generated output
	 */
	public function batchAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->batch() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for a copy of a resource object
	 *
	 * @return string Generated output
	 */
	public function copyAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->copy() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for a new resource object
	 *
	 * @return string Generated output
	 */
	public function createAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->create() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Deletes the resource object or a list of resource objects
	 *
	 * @return string Generated output
	 */
	public function deleteAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}


		$cntl = $this->createAdmin();

		if( ( $html = $cntl->delete() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Exports the data for a resource object
	 *
	 * @return string Generated output
	 */
	public function exportAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->export() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for the requested resource object
	 *
	 * @return string Generated output
	 */
	public function getAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->get() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Saves a new resource object
	 *
	 * @return string Generated output
	 */
	public function saveAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->save() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the HTML code for a list of resource objects
	 *
	 * @return string Generated output
	 */
	public function searchAction()
	{
		if( config( 'shop.authorize', true ) ) {
			$this->authorize( 'admin', [JqadmController::class, config( 'shop.roles', ['admin', 'editor'] )] );
		}

		$cntl = $this->createAdmin();

		if( ( $html = $cntl->search() ) == '' ) {
			return $cntl->response();
		}

		return $this->getHtml( $html );
	}


	/**
	 * Returns the resource controller
	 *
	 * @return \Aimeos\Admin\JQAdm\Iface JQAdm client
	 */
	protected function createAdmin() : \Aimeos\Admin\JQAdm\Iface
	{
		$site = Route::input( 'site', Request::get( 'site', config( 'shop.mshop.locale.site', 'default' ) ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );
		$resource = Route::input( 'resource' );

		$view->aimeosType = 'Laravel';
		$view->aimeosVersion = app( 'aimeos' )->getVersion();
		$view->aimeosExtensions = implode( ',', $aimeos->getExtensions() );

		$context->setView( $view );

		return \Aimeos\Admin\JQAdm::create( $context, $aimeos, $resource );
	}


	/**
	 * Returns the generated HTML code
	 *
	 * @param string $content Content from admin client
	 * @return \Illuminate\Contracts\View\View View for rendering the output
	 */
	protected function getHtml( string $content )
	{
		$site = Route::input( 'site', Request::get( 'site', config( 'shop.mshop.locale.site', 'default' ) ) );
		$lang = Request::get( 'locale', config( 'app.locale', 'en' ) );

		return View::make( 'shop::jqadm.index', [
			'content' => $content,
			'site' => $site,
			'locale' => $lang,
			'localeDir' => in_array( $lang, ['ar', 'az', 'dv', 'fa', 'he', 'ku', 'ur'] ) ? 'rtl' : 'ltr',
			'theme' => ( $_COOKIE['aimeos_backend_theme'] ?? '' ) == 'dark' ? 'dark' : 'light'
		] );
	}
}
