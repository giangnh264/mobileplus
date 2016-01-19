<?php
class filterPopupWidget extends CWidget
{
	public $route = '/album/index';
	public $type='';
	public $title='';
	public $title_actived='TẤT CẢ THỂ LOẠI';
	public function run()
	{
		$params = array();
		if($this->type=='category'){
			$genres = MainActiveRecord::getGenre();
			$genresAll = WapGenreModel::model()->cache(1000,null)->findAll('status=1');
			$genreRoot = array();
			foreach ($genresAll as $key => $value){
				if($value->parent_id==0)
					$genreRoot[] = $value;
			}
			$params = array(
					'genreRoot' => $genreRoot,
					'genresAll' => $genresAll,
					'genres' 	=> $genres,
			);
		}
		$this->render('default',
				CMap::mergeArray(array(
					'title'=>$this->title,
					'type'=>$this->type,
					'title_actived'=>$this->title_actived,
					'route'=>$this->route,
				),
				$params
			)
		);
	}
}