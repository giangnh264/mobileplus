<?php
class RelatedArtists extends CWidget {
	
    public $artists;    
    public $pageTitle = 'Related artists';
    public $more = null;
    public $exclusion = null;

    public function run() {
        $this->render('relatedArtists', array(
            'artists' => $this->artists,
            'pageTitle'=>$this->pageTitle,
        	'more'=>$this->more,
        	'exclusion' => $this->exclusion
        ));
    }
}