<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Imagine{
    //private	$CI;

    public function uploadAvatar($photo = '')
    {
        if (!$photo) return false;
        $avatar = array();
        $avatar_temp = 'upload/temp/'.sha1(time());

        $photo_buffer = file_get_contents($photo);
        if (!$photo_buffer) return false;

        if (!file_put_contents(FCPATH.$avatar_temp,$photo_buffer)) return false;

        if (class_exists('finfo')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $avatar['mime_type'] = $finfo->buffer($photo_buffer);
            if ($avatar['mime_type'] == 'image/png') $avatar['ext'] = 'png';
            elseif ($avatar['mime_type'] == 'image/jpeg') $avatar['ext'] = 'jpg';
            elseif ($avatar['mime_type'] == 'image/gif') $avatar['ext'] = 'gif';
            else {
                unlink(FCPATH.$avatar_temp);
                return false;
            }

        } else {
            $file_parts = explode('.',$photo);
            $ext = end($file_parts);
            if ($ext != 'png' && $ext != 'jpg' && $ext != 'gif' && $ext != 'jpeg') {
                unlink(FCPATH.$avatar_temp);
                return false;
            }

            if ($ext == 'jpeg') $ext = 'jpg';
            $avatar['ext'] = $ext;
        }


        $store_name = sha1($photo.time()).'.'.$avatar['ext'];

        $avatar['s'] = 'upload/avatars/s_'.$store_name;
        $avatar['m'] = 'upload/avatars/m_'.$store_name;
        $avatar['b'] = 'upload/avatars/'.$store_name;
        $avatar['xl'] = 'upload/avatars/xl_'.$store_name;

        if (class_exists('Imagick')) {
            $image = new Imagick(FCPATH.$avatar_temp);

            $image->cropThumbnailImage(107, 107);
            $image->writeImage(FCPATH.$avatar['b']);
            $image->cropThumbnailImage(60, 60);
            $image->writeImage(FCPATH.$avatar['m']);
            $image->cropThumbnailImage(24, 24);
            $image->writeImage(FCPATH.$avatar['s']);

            unset($image);

        } else {
            copy(FCPATH.$avatar_temp,FCPATH.$avatar['b']);
            copy(FCPATH.$avatar_temp,FCPATH.$avatar['m']);
            copy(FCPATH.$avatar_temp,FCPATH.$avatar['s']);
        }


        $data = array(
            'avatar_s' => $avatar['s'],
            'avatar_m' => $avatar['m'],
            'avatar_b' => $avatar['b']
        );

        return $data;
    }

    public function proccessPhoto($file, $sizes = false)
    {
        if (!$file || !isset($file['store_name']) || !$file['store_name'] || !isset($file['upload_path']) || !$file['upload_path']) return false;

        if (!$sizes || !is_array($sizes)) {
            $sizes = array(
                array('key'=>'b','prefix'=>'b_', 'thumb'=>false, 'width'=>800, 'height'=>600),
                array('key'=>'m','prefix'=>'m_', 'thumb'=>true, 'width'=>216, 'height'=>184),
                array('key'=>'s','prefix'=>'s_', 'thumb'=>true, 'width'=>60, 'height'=>60),
            );
        }

        if (class_exists('Imagick')) {
            $image = new Imagick(FCPATH.$file['upload_path'].$file['store_name']);

            $height=$image->getImageHeight();
            $width=$image->getImageWidth();

            $proccessed = array();

            foreach($sizes as $s)
            {
                if ($s['thumb']) {
                    $image->cropThumbnailImage($s['width'], $s['height']);
                } else {
                    if ($width > 0 && $height > 0){

                        $crop = (isset($s['crop']) && $s['crop'] && is_array($s['crop']))?1:0;

                        if ($crop) {
                            if ($width/$height < 620/390) $image->scaleImage($s['width'],0);
                            else $image->scaleImage(0,$s['height']);
                            $image->cropImage($s['width'], $s['height'], $s['crop']['x'], $s['crop']['y']);
                        } else {
                            if ($height > $width) $image->scaleImage($s['width'],0);
                            else $image->scaleImage(0,$s['height']);
                        }
                    }
                }

                $key = $s['key'];
                $el = $file['upload_path'].$s['prefix'].$file['store_name'];
                $proccessed[$key] = $el;
                $image->writeImage(FCPATH.$el);
            }

            unset($image);
            return $proccessed;
        }
    }

}