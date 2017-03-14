<?php

class pluginIsso extends Plugin {

	private $enable, $customCss;

	public function init()
	{
		$this->dbFields = array(
			'enablePages'=>0,
			'enablePosts'=>0,
			'enableDefaultHomePage'=>1,
			'pathData'=>'',
            'pathSrc'=>'',
            'pathCss'=>'',
            'dataLang'=>'',
            'dataReplySelf'=>0,
            'dataRequireEmail'=>'',
            'dataCommentsTop'=>'',
            'dataCommentsNested'=>'',
            'dataRevealClick'=>'',
            'dataAvatar'=>'',
            'dataAvatarBg'=>'',
            'dataAvatarFg'=>'',
            'dataVote'=>''
		);
	}

	function __construct()
	{
		parent::__construct();

		global $Url;

		$this->enable = false;

		if( $this->getDbField('enablePosts') && ($Url->whereAmI()=='post') ) {
			$this->enable = true;
		}
		elseif( $this->getDbField('enablePages') && ($Url->whereAmI()=='page') ) {
			$this->enable = true;
		}
		elseif( $this->getDbField('enableDefaultHomePage') && ($Url->whereAmI()=='home') ) {
			$this->enable = true;
		}
		
		if( Text::isEmpty($this->getDbField('pathCss')) ) {
		    $this->customCss = false;
		} else {
		    $this->customCss = true;
		}
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input name="enablePages" id="jsenablePages" type="checkbox" value="1" '.($this->getDbField('enablePages')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('Enable Isso on pages').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="1" '.($this->getDbField('enablePosts')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('Enable Isso on posts').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enableDefaultHomePage" id="jsenableDefaultHomePage" type="checkbox" value="1" '.($this->getDbField('enableDefaultHomePage')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenableDefaultHomePage">'.$Language->get('Enable Isso on default home page').'</label>';
		$html .= '</div>';
		
		$html .= '<p><h3>'.$Language->get('Required settings').':</h3></p>';
		
		$html .= '<div>';
		$html .= '<label>data-isso: '.$Language->get('Path to Isso data (e.g. your fcgi script)').'</label>';
		$html .= '<input name="pathData" id="jsdata" type="text" value="'.$this->getDbField('pathData').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>src: '.$Language->get('Path to script source for Isso (e.g. embed.js)').'</label>';
		$html .= '<input name="pathSrc" id="jssource" type="text" value="'.$this->getDbField('pathSrc').'">';
		$html .= '</div>';
		
		$html .= '<p><h3>'.$Language->get('Optional settings').':</h3></p>';
		
		$html .= '<form>';
		$html .= '<label>data-isso-reply-to-self: [true/false]</label>';
		$html .= '<input name="datareplyself" id="jsdatareplyself" type="radio" value="1" '.(($this->getDbField('dataReplySelf'))?'checked':'').'> true</br>';
		$html .= '<input name="datareplyself" id="jsdatareplyself2" type="radio" value="0" '.((!$this->getDbField('dataReplySelf'))?'checked':'').'> false';
		$html .= '</form>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-require-email: [true/false]</label>';
		$html .= '<input name="datarequireemail" id="jsdatarequireemail" type="text" value="'.$this->getDbField('dataRequireEmail').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-vote: [true/false]</label>';
		$html .= '<input name="datavote" id="jsdatavote" type="text" value="'.$this->getDbField('dataVote').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-avatar: [true/false]</label>';
		$html .= '<input name="dataavatar" id="jsdataavatar" type="text" value="'.$this->getDbField('dataAvatar').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-avatar-fg: ['.$Language->get('#colorcode').']</label>';
		$html .= '<input name="dataavatarfg" id="jsdataavatarfg" type="text" value="'.$this->getDbField('dataAvatarFg').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-avatar-bg: ['.$Language->get('#colorcode').']</label>';
		$html .= '<input name="dataavatarbg" id="jsdataavatarbg" type="text" value="'.$this->getDbField('dataAvatarBg').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-lang: ['.$Language->get('(two letter) language code').']</label>';
		$html .= '<input name="datalang" id="jsdatalang" type="text" value="'.$this->getDbField('dataLang').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-max-comments-top: ['.$Language->get('number').']</label>';
		$html .= '<input name="datacommentstop" id="jsdatacommentstop" type="text" value="'.$this->getDbField('dataCommentsTop').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-max-comments-nested: ['.$Language->get('number').']</label>';
		$html .= '<input name="datacommentsnested" id="jsdatacommentsnested" type="text" value="'.$this->getDbField('dataCommentsNested').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-reveal-on-click: ['.$Language->get('number').']</label>';
		$html .= '<input name="datarevealclick" id="jsdatarevealclick" type="text" value="'.$this->getDbField('dataRevealClick').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>'.$Language->get('Path to custom CSS').'</label>';
		$html .= '<input name="datacss" id="jsdatacss" type="text" value="'.$this->getDbField('pathCss').'">';
		$html .= '</div>';

		return $html;
	}

	public function postEnd()
	{
		if( $this->enable ) {
			return '<section id="isso-thread"></section>';
		}

		return false;
	}

	public function pageEnd()
	{
		global $Url;

		// Bludit check not-found page after the plugin method construct.
		// It's necesary check here the page not-found.

		if( $this->enable && !$Url->notFound()) {
			return '<section id="isso-thread"></section>';
		}

		return false;
	}

	public function siteHead()
	{
		if( $this->enable ) {
			$html = '<style>#isso-thread { margin: 20px 0 !important }</style>';
			
			if( $this->customCss ) {
			    $html .= '<link rel="stylesheet" href="'.$this->getDbField('pathCss').'">';
			}
			
			$html .= '<script ';
			$html .= 'data-isso="'.$this->getDbField('pathData').'" ';
			$html .= 'src="'.$this->getDbField('pathSrc').'" ';
			
			if( $this->getDbField('dataReplySelf') === 'true' || $this->getDbField('dataReplySelf') === 'false' ) {
			    $html .= 'data-isso-reply-to-self="'.$this->getDbField('dataReplySelf').'" ';
			}
			
			if( $this->getDbField('dataRequireEmail') === 'true' || $this->getDbField('dataRequireEmail') === 'false' ) {
			    $html .= 'data-isso-require-email="'.$this->getDbField('dataRequireEmail').'" ';
			}
			
			if( $this->getDbField('dataVote') === 'true' || $this->getDbField('dataVote') === 'false' ) {
			    $html .= 'data-isso-vote="'.$this->getDbField('dataVote').'" ';
			}
			
			if( $this->getDbField('dataAvatar') === 'true' || $this->getDbField('dataAvatar') === 'false' ) {
			    $html .= 'data-isso-avatar="'.$this->getDbField('dataAvatar').'" ';
			}
			
			if( !empty($this->getDbField('dataAvatarFg')) ) {
			    $html .= 'data-isso-avatar-fg="'.$this->getDbField('dataAvatarFg').'" ';
			}
			
			if( !empty($this->getDbField('dataAvatarBg')) ) {
			    $html .= 'data-isso-avatar-bg="'.$this->getDbField('dataAvatarBg').'" ';
			}
			
			if( !empty($this->getDbField('dataLang')) ) {
			    $html .= 'data-isso-lang="'.$this->getDbField('dataLang').'" ';
			}
			
			if( is_numeric( $this->getDbField('dataCommentsTop') ) ) {
			    $html .= 'data-isso-max-comments-top="'.$this->getDbField('dataCommentsTop').'" ';
			}
			
			if( is_numeric( $this->getDbField('dataCommentsNested') ) ) {
			    $html .= 'data-isso-max-comments-nested="'.$this->getDbField('dataCommentsNested').'" ';
			}
			
			if( is_numeric( $this->getDbField('dataRevealClick') ) ) {
			    $html .= 'data-isso-reveal-on-click="'.$this->getDbField('dataRevealClick').'" ';
			}
			
			if( $this->customCss ) {
			    $html .= 'data-isso-css="false" ';
			} else {
			    $html .= 'data-isso-css="true" ';
			}
			
			$html .= '></script>';
			
			return $html;
		}

		return false;
	}
}
