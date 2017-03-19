<?php

class pluginIsso extends Plugin {

	private $enable;

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
            'dataReplySelf'=>'false',
            'dataRequireAuthor'=>'true',
            'dataRequireEmail'=>'false',
            'dataCommentsTop'=>'10',
            'dataCommentsNested'=>'5',
            'dataRevealClick'=>'5',
            'dataAvatar'=>'true',
            'dataAvatarBg'=>'',
            'dataAvatarFg'=>'',
            'dataVote'=>'true'
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
		
		$html .= '<div>';
		$html .= '<label>data-isso-reply-to-self: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataReplySelf" id="jsdatareplyself_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataReplySelf') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataReplySelf" id="jsdatareplyself_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataReplySelf') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-require-author: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataRequireAuthor" id="jsdatarequireauthor_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataRequireAuthor') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataRequireAuthor" id="jsdatarequireauthor_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataRequireAuthor') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-require-email: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataRequireEmail" id="jsdatarequireemail_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataRequireEmail') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataRequireEmail" id="jsdatarequireemail_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataRequireEmail') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-vote: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataVote" id="jsdatavote_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataVote') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataVote" id="jsdatavote_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataVote') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-avatar: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataAvatar" id="jsdataavatar_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataAvatar') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataAvatar" id="jsdataavatar_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataAvatar') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-avatar-fg: ['.$Language->get('colorcode').']</label>';
		$html .= '<input name="dataAvatarFg" id="jsdataavatarfg" type="text" value="'.$this->getDbField('dataAvatarFg').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-avatar-bg: ['.$Language->get('colorcode').']</label>';
		$html .= '<input name="dataAvatarBg" id="jsdataavatarbg" type="text" value="'.$this->getDbField('dataAvatarBg').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-lang: ['.$Language->get('language code').']</label>';
		$html .= '<input name="dataLang" id="jsdatalang" type="text" value="'.$this->getDbField('dataLang').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-max-comments-top: ['.$Language->get('number').']</label>';
		$html .= '<input name="dataCommentsTop" id="jsdatacommentstop" type="number" min="0" value="'.$this->getDbField('dataCommentsTop').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-max-comments-nested: ['.$Language->get('number').']</label>';
		$html .= '<input name="dataCommentsNested" id="jsdatacommentsnested" type="number" min="0" value="'.$this->getDbField('dataCommentsNested').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-reveal-on-click: ['.$Language->get('number').']</label>';
		$html .= '<input name="dataRevealClick" id="jsdatarevealclick" type="number" min="0" value="'.$this->getDbField('dataRevealClick').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>'.$Language->get('Path to custom CSS file').'</label>';
		$html .= '<input name="pathCss" id="jsdatacss" type="text" value="'.$this->getDbField('pathCss').'">';
		$html .= '</div>';

		return $html;
	}

	public function postEnd()
	{
		global $Language;

		if( $this->enable ) {
			$html = '<section id="isso-thread"></section>';
			$html .= '<noscript>'.$Language->get('The comment section powered by isso can not be shown without javascript!');
			$html .= '</noscript>';
			return $html;
		}

		return false;
	}

	public function pageEnd()
	{
		global $Url;
		global $Language;

		// Bludit check not-found page after the plugin method construct.
		// It's necesary check here the page not-found.

		if( $this->enable && !$Url->notFound()) {
			$html = '<section id="isso-thread"></section>';
			$html .= '<noscript>'.$Language->get('The comment section powered by isso can not be shown without javascript!');
			$html .= '</noscript>';
			return $html;
		}

		return false;
	}

	public function siteHead()
	{
		if( $this->enable ) {
			$html = '<style>#isso-thread { margin: 20px 0 !important }</style>';
			
			if( !Text::isEmpty($this->getDbField('pathCss')) ) {
			    $html .= '<link rel="stylesheet" href="'.trim($this->getDbField('pathCss')).'">';
			}
			
			$html .= '<script ';
			$html .= 'data-isso="'.$this->getDbField('pathData').'" ';
			$html .= 'src="'.$this->getDbField('pathSrc').'" ';
			
			if( $this->getDbField('dataReplySelf') == 'true' || $this->getDbField('dataReplySelf') == 'false' ) {
			    $html .= 'data-isso-reply-to-self="'.$this->getDbField('dataReplySelf').'" ';
			}
			
			if( $this->getDbField('dataRequireEmail') == 'true' || $this->getDbField('dataRequireEmail') == 'false' ) {
			    $html .= 'data-isso-require-email="'.$this->getDbField('dataRequireEmail').'" ';
			}
			
			if( $this->getDbField('dataVote') == 'true' || $this->getDbField('dataVote') == 'false' ) {
			    $html .= 'data-isso-vote="'.$this->getDbField('dataVote').'" ';
			}
			
			if( $this->getDbField('dataAvatar') == 'true' || $this->getDbField('dataAvatar') == 'false' ) {
			    $html .= 'data-isso-avatar="'.$this->getDbField('dataAvatar').'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('dataAvatarFg')) ) {
			    $html .= 'data-isso-avatar-fg="'.trim($this->getDbField('dataAvatarFg')).'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('dataAvatarBg')) ) {
			    $html .= 'data-isso-avatar-bg="'.trim($this->getDbField('dataAvatarBg')).'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('dataLang')) ) {
			    $html .= 'data-isso-lang="'.trim($this->getDbField('dataLang')).'" ';
			}
			
			if( Valid::int( $this->getDbField('dataCommentsTop') ) ) {
			    $html .= 'data-isso-max-comments-top="'.$this->getDbField('dataCommentsTop').'" ';
			}
			
			if( Valid::int( $this->getDbField('dataCommentsNested') ) ) {
			    $html .= 'data-isso-max-comments-nested="'.$this->getDbField('dataCommentsNested').'" ';
			}
			
			if( Valid::int( $this->getDbField('dataRevealClick') ) ) {
			    $html .= 'data-isso-reveal-on-click="'.$this->getDbField('dataRevealClick').'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('pathCss')) ) {
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
