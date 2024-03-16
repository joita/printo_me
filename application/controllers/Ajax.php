<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends MY_Controller {

	public function fonts()
	{
		$this->load->model('fonts_m');
		$fonts = $this->fonts_m->getFonts(false, '', '', 1000, 0, true);

		$data         = array();
		$google_fonts   = array();
		if (count($fonts) == 0)
		{
			$data['status'] = 0;
		}
		else
		{
			$data['status'] = 1;

			if (count($fonts))
			{
				foreach ($fonts as $font)
				{
					if ($font->type == 'google')
						$google_fonts[] = $font->title;
				}
			}
			$data['fonts']          = array();

			$google_fonts         = implode('|', $google_fonts);
			$google_fonts         = str_replace(' ', '+', $google_fonts);
			$data['fonts']['google_fonts']  = $google_fonts;

			$data['fonts']['fonts']     = $fonts;

		}
		echo json_encode($data);
		exit();
	}

	public function colors()
	{
		$this->load->model('colors_m');
		$rows     = $this->colors_m->getColors(false, '', 1000, '', true);

		$colors   = array();
		$data   = array();
		if(count($rows))
		{
			$data['status'] = 1;
			$i = 0;
			foreach($rows as $color){

				$colors[$i]       = array();
				$colors[$i]['title']  = $color->title;
				$colors[$i]['hex']    = $color->hex;
				$i++;
			}
		}
		else
		{
			$data['status'] = 0;
		}

		$data['colors'] = $colors;

		echo json_encode($data);
		exit();
	}

	public function upload()
	{

		$status = "";
		$msg = "";
		$file_element_name = 'myfile';

		$this->load->library('file');
		$file     = new File();

		$date   = new DateTime();
		$year = $date->format('Y');
		$month  = $date->format('m');
		$assets = APPPATH. '../public/media/assets';
		$uploaded = $assets  .'/'. 'uploaded';
		$folder_year = $uploaded .'/'. $year;
		$folder_month = $folder_year .'/'. $month;

		// create folder
		if (!file_exists($assets))
			$file->create($assets, 0755);

		// create folder
		if (!file_exists($uploaded))
			$file->create($uploaded, 0755);

		// create folder
		if (!file_exists($folder_year))
			$file->create($folder_year, 0755);

		// create folder
		if (!file_exists($folder_month))
			$file->create($folder_month, 0755);


		$config['upload_path']    = $folder_month;
		$config['allowed_types']  = 'gif|jpg|png|jpeg';
		$config['max_size']     = 1024 * 20;

		$this->upload->initialize($config);

		if (!$this->upload->do_upload($file_element_name))
		{
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
		}
		else
		{
			$data         = $this->upload->data();
			$image        = new stdClass();

			$image->file_name = $data['file_name'];
			$image->file_type = $data['image_type'];
			$image->title   = $data['raw_name'];
			$image->width   = $data['image_width'];
			$image->height    = $data['image_height'];
			$image->change_color= 0;
			$image->url     = base_url() .'media/assets/uploaded/'. $year .'/'. $month .'/'. $image->file_name;

			$config['image_library'] = 'gd2';
			$config['source_image'] = $folder_month .'/'. $image->file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']  = 300;
			$config['height'] = 300;

			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$thumb = str_replace($this->image_lib->dest_folder, '', $this->image_lib->full_dst_path);

			$image->thumb = base_url() .'media/assets/uploaded/'. $year .'/'. $month .'/'. $thumb;

			//$palette = ColorThief\ColorThief::getPalette($image->url, 10, 3);
			$palette = League\ColorExtractor\Palette::fromFilename($image->url/* , League\ColorExtractor\Color::fromHexToInt('#FFFFFF') */);
			//$image->palette = array();

			if(sizeof($palette) == 0) {
				usleep(500000);
				$palette = League\ColorExtractor\Palette::fromFilename($image->url/* , League\ColorExtractor\Color::fromHexToInt('#FFFFFF') */);
			}

			$extractor = new League\ColorExtractor\ColorExtractor($palette);
			$colors = $extractor->extract(5);

			foreach($colors as $indice=>$color) {
				//$colors[$indice] = League\ColorExtractor\Color::fromIntToRgb($color);
				//$red = str_pad(dechex($colors[$indice]['r']), 2, 0);
				//$green = str_pad(dechex($colors[$indice]['g']), 2, 0);
				//$blue = str_pad(dechex($colors[$indice]['b']), 2, 0);

				//$colors[$indice] = strtoupper($red.$green.$blue);

                $colors[$indice] = str_replace("#", "", League\ColorExtractor\Color::fromIntToHex($color));
			}

			$image->palette = $colors;

			//$image->palette = array_map("unserialize", array_unique(array_map("serialize", $palette)));

			/* if(sizeof($palette) == 0) {
				$image->palette[0] = '#ffffff';
			} */
			//foreach($palette as $index=>$pal) {
			//	$color = rgb2hex($pal);
			//	array_push($image->palette, $color);
			//}

			$msg        = $image;
		}
		echo json_encode(array('status' => $status, 'msg' => $msg, 'root' => $folder_month));
	}

}
