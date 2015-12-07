<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'].'/application/controllers/MY_base_controller.php');
use JMS\Serializer\Serializer;
use Doctrine\ORM\PersistentCollection;
class Categories extends MY_base_controller{

    public $per_page = 20;
    public $module = 'categories';

    /** @var  categories_model */
    public $categories_model;
    /** @var  poses_model */
    public $poses_model;
    /** @var  arrows_model */
    public $arrows_model;
    /** @var  transformations_model */
    public $transformations_model;
    /** @var  transform_model */
    public $transform_model;
    /** @var  clouds_model */
    public $clouds_model;
    /** @var  cloud_texts_model */
    public $cloud_texts_model;
    /** @var Doctrine\ORM\EntityManager $em */
    protected $em;
    public $photo_extension = '.jpg';
    public $circuit_extension = '.png';

    public $languages;
    public $arrows_map = [
        0 => [
            'direction' => 'left',
            'type' => 1
        ],
        1 => [
            'direction' => 'left',
            'type' => 2
        ],
        2 => [
            'direction' => 'left',
            'type' => 3
        ],
        4 => [
            'direction' => 'right',
            'type' => 1
        ],
        5 => [
            'direction' => 'right',
            'type' => 2
        ],
        6 => [
            'direction' => 'right',
            'type' => 3
        ],
        'scale',
        'translate'
    ];
    function __construct()
    {
        parent::__construct('categories');
        $this->languages = $this->languages_model->get_languages_associated();
        $this->bulk_actions = [
            'separated' =>
                [
                    [
                        'url' => 'categories/ajax_delete',
                        'title' => lang('delete'),
                        'class' => 'danger'
                    ]
                ],
            [
                'url' => 'categories/ajax_activate',
                'title' => lang('make_active'),
                'class' => 'info'
            ],
            [
                'url' => 'categories/ajax_deactivate',
                'title' => lang('make_inactive'),
                'class' => 'warning'
            ],
            [
                'url' => 'categories/ajax_publish',
                'title' => lang('make_published'),
                'class' => 'info'
            ],
            [
                'url' => 'categories/ajax_unpublish',
                'title' => lang('make_unpublished'),
                'class' => 'warning'
            ],
            [
                'url' => 'categories/ajax_chargeable',
                'title' => lang('make_chargeable'),
                'class' => 'info'
            ],
            [
                'url' => 'categories/ajax_free',
                'title' => lang('make_free'),
                'class' => 'warning'
            ]
        ];
    }

    public function index($page = 1)
    {
        $pages = 12;
        $list = [
            [
                'title' => 'Сидя',
                'id' => 1,
                'active' => 1,
                'published' => 1,
                'free' => 0,
                'poses' => '-',
                'subcategories' => [['32'], ['21313'], ['13123']]
            ],
            [
                'title' => 'Стоя',
                'id' => 2,
                'active' => 0,
                'published' => 1,
                'free' => 1,
                'poses' => 8,
                'subcategories' => []
            ],
            [
                'title' => 'Лежа',
                'active' => 0,
                'id' => 3,
                'published' => 1,
                'free' => 0,
                'poses' => 14,
                'subcategories' => []
            ],
            [
                'title' => 'Сидя',
                'id' => 1,
                'active' => 1,
                'published' => 1,
                'free' => 0,
                'poses' => '-',
                'subcategories' => [['32'], ['21313'], ['13123']]
            ],
            [
                'title' => 'Стоя',
                'id' => 2,
                'active' => 0,
                'published' => 1,
                'free' => 1,
                'poses' => 8,
                'subcategories' => []
            ],
            [
                'title' => 'Лежа',
                'active' => 0,
                'id' => 3,
                'published' => 1,
                'free' => 0,
                'poses' => 14,
                'subcategories' => []
            ]
        ];
        $this->render_view('index', [['url' => 'categories', 'title' => 'Categories']], ['list' => $list, 'page' => $page, 'pages' => $pages] , 'categories');
    }


    public function create()
    {
        $breadcrumbs = [
            ['url' => 'categories', 'title' => lang('categories_title')],
            ['url' => 'categories/create', 'title' => lang('add_category')]
        ];
        $this->em = $this->container->get('doctrine')->em;
        $this->languages_d = $this->em->getRepository('Application\Models\Entities\Languages')->findAll();
        $devices = $this->em->getRepository('Application\Models\Entities\Devices')->findAll();
        if($_FILES)
        {
            $missed = 0;
            $errors = 0;
            foreach($_FILES as $f)
            {
                if($f['error'] != 0 || $f['size'] == 1)
                {
                    $missed++;
                    continue;
                }
                if($f['type'] != 'application/zip')
                {
                   $errors++;
                    continue;
                }
            }
            if(!$missed && !$errors)
            {
                try
                {
                    $category = null;
                    foreach($_FILES as $device_id => $file)
                    {
                        $category = $this->process_archive_d($device_id, $file['tmp_name'], $file['name'], $category);
                    }
                    $poses_count = 0;
                    /** @var  $sub Application\Models\Entities\PosesCategories */
                    foreach($category->getChildren() as $sub)
                    {
                        $this->em->refresh($sub);
                        $poses_count += $sub->getPoses()->count();

                    }
                    $poses_count = $poses_count/count($_FILES);
                    $this->session->set_flashdata('success', ['title' => lang('success'), 'text' => sprintf(lang('archive_success'), $category->getChildren()->count(), $poses_count)]);
                    redirect($this->module.'/edit/'.$category->getId());
                    return;
                }
                catch(Exception $e)
                {
                    $this->messages[] = ['title' => lang('error'), 'text' => $e->getMessage(), 'class' => 'danger'];
                }


            }
            else
            {
                if($errors)  $this->messages[] = ['title' => lang('error'), 'text' => lang('archive_format_error'), 'class' => 'danger'];
                if($missed) $this->messages[] = ['title' => lang('error'), 'text' => sprintf(lang('devices_error'), $missed), 'class' => 'danger'];
            }

        }
        $this->render_view('create', $breadcrumbs, [
            'devices' => $devices
        ] , 'categories');
    }








    public function edit($id)
    {
        $this->em = $this->container->get('doctrine')->em;
       /** @var  $category Application\Models\Entities\PosesCategories */
        $category = $this->em->find('Application\Models\Entities\PosesCategories', $id);
        if(!$category)
        {
            $this->session->set_flashdata('danger', ['title' => lang('error'), 'text' => lang('category_not_found')]);
            redirect($this->module);
        }
//        $item = [
//            'active' => $category->isActive(),
//            'id' => $category->getId(),
//            'published' => $category->isPublished(),
//            'chargeable' => $category->isChargeable(),
//            'poses' => $category->getPoses()->count(),
//            'subcategories' => [],
//            'titles' => []
//        ];
//        /** @var  $title \Application\Models\Entities\PosesCategoriesTexts */
//        foreach($category->getTitles() as $title)
//        {
//            $item['titles'][$title->getLanguage()->getId()];
//        }



        $breadcrumbs = [
            ['url' => 'categories', 'title' => lang('categories_title')],
            ['url' => 'categories/edit/'.$id, 'title' => lang('edit')]
        ];
        $this->render_view('form', $breadcrumbs, ['category' => $category] , 'categories');
    }

    protected function process_archive($device_id = 1, $filename = 'portrait.zip')
    {
        ini_set("memory_limit","512M");
        set_time_limit(0);
        $this->load->model('poses_model');
        $this->load->model('clouds_model');
        $this->load->model('cloud_texts_model');
        $this->load->model('arrows_model');
        $this->load->model('transformations_model');
        $this->load->model('transform_model');
        $category_id = $this->categories_model->create_category();
        $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/';
        $archives_folder = $_SERVER['DOCUMENT_ROOT'].'/assets/archives/';
        $uploaded_zip = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$filename;
        if(!is_dir($archives_folder.$category_id))
        {
            mkdir($archives_folder.$category_id, 0777, true);
        }
        $zip_file = $archives_folder.$category_id.'/'.time().'.zip';
        copy($uploaded_zip, $zip_file ); // Change to move_uploaded_file!!!
        $zip = new ZipArchive;
        $res = $zip->open($zip_file);
        if(!$res)
        {
            throw new Exception('ZIP file opening error!', 500);
        }
        $folder = $targetFolder . str_replace('.zip', '', $filename);
        if(is_dir($folder))
        {
            $folder .= time();
        }
        $folder .= '/';
        mkdir($folder, 0777, true);
        $extracted = $zip->extractTo($folder);
        $zip->close();
        if(!$extracted)
        {
            throw new Exception('ZIP extracting error!', 500);
        }
        $folder_data = opendir($folder);
        $result = [];
        $category_name = '';
        while (($category_folder = readdir($folder_data)) !== false) {
            if(filetype($folder . $category_folder) == 'dir' && !in_array($category_folder, ['..', '.', '...']))
            {
                $this->categories_model->set_categories_titles($this->generate_titles_array($category_id, $category_folder));
                $category_name = ucfirst($category_folder);
                if(is_dir($folder . $category_folder.'/open'))
                {
                    $result[$category_folder] = $this->process_pose($folder . $category_folder, $category_id, $device_id);
                }
                else
                {
                    $category_data = opendir($folder . $category_folder);
                    while (($subcategory_folder = readdir($category_data)) !== false) {
                        if(filetype($folder . $category_folder.'/'.$subcategory_folder) == 'dir' && !in_array($subcategory_folder, ['..', '.', '...']))
                        {
                            $subcategory_id = $this->categories_model->create_category($category_id);
                            $this->categories_model->set_categories_titles($this->generate_titles_array($subcategory_id, $subcategory_folder));
                            $result[$category_folder][$subcategory_folder] = $this->process_pose($folder . $category_folder.'/'.$subcategory_folder, $subcategory_id, $device_id);
                        }

                    }
                }
            }
        }
        closedir($folder_data);
        chmod($folder, 0777);
//        try
//        {
//            unlink($folder);
//        }
//        catch (Exception $e)
//        {
//            // Do nothing
//        }
        $category = array_shift($result);
        $subcategories = count($category);
        $poses = 0;
        foreach($category as $subcategory_row)
        {
            $poses += count($subcategory_row);
        }
        $response = [
            'category_name' => $category_name,
            'subcategories' => $subcategories,
            'poses' => $poses
        ];

        return $response;
    }

    private function process_pose($folder, $category_id, $device_id)
    {
        $data = [];
        $images_folder = $_SERVER['DOCUMENT_ROOT'].'/assets/images/';
        $folder .= '/';
        chmod($folder, 0777);
        $data_folder = $folder.'data/tips_data/';
        $circuits_folder = $folder.'data/circuit/';
        $photo_folder = $folder.'photo/';
        if(!is_dir($data_folder) || !is_dir($photo_folder))
        {
            throw new Exception ('Wrong Archive structure', 400);
        }
        $folder_data = opendir($data_folder);
        while (($pose_folder = readdir($folder_data)) !== false)
        {
            $pose_path = $data_folder . $pose_folder;
            if(filetype($pose_path) != 'dir' || in_array($pose_folder, ['..', '.', '...']))
            {
                continue;
            }

            $pose_path .= '/';
            $pose_data = opendir($pose_path);
            $pose_id = $this->poses_model->add([
                'category_id' => $category_id,
                'device_id' => $device_id
            ]);
            $pose_image_variants = [
                $photo_folder.$pose_folder.'@2x'.$this->photo_extension,
                $photo_folder.$pose_folder.'@3x'.$this->photo_extension,
                $photo_folder.$pose_folder.$this->photo_extension
            ];
            $pose_image = null;
            foreach($pose_image_variants as $im)
            {
                if(file_exists($im))
                {
                    $pose_image = $im;
                    break;
                }
            }
            if(is_null($pose_image))
            {
                throw new Exception (sprintf(lang('pose_picture_error'), $pose_folder), 400);
            }
            $pose_photo_path = $images_folder.'poses/'.$pose_id.'/';
            if(!is_dir($pose_photo_path))
            {
                mkdir($pose_photo_path, 0777, true);
            }
            rename($pose_image, $pose_photo_path.'main_'.$device_id.$this->photo_extension);
            $exploded_name = explode('-', $pose_folder);
            $circuit_name = $exploded_name[0].'-'.$exploded_name[1].'-c-'.$exploded_name[2];
            $circuit_image_variants = [
                $circuits_folder.$circuit_name.'@2x'.$this->circuit_extension,
                $circuits_folder.$circuit_name.'@3x'.$this->circuit_extension,
                $circuits_folder.$circuit_name.$this->circuit_extension
            ];
            $circuit_image = null;
            foreach($circuit_image_variants as $im)
            {
                if(file_exists($im))
                {
                    $circuit_image = $im;
                    break;
                }
            }
            if(!is_null($circuit_image))
            {
                rename($circuit_image, $pose_photo_path.'circuit_'.$device_id.$this->circuit_extension);
            }

            $result = [];
            while(($file = readdir($pose_data)) !== false)
            {
                $file_info = new SplFileInfo($file);

                if($file_info->getExtension() == 'plist')
                {
                    $xml = simplexml_load_file($pose_path.$file);
                    $index = str_replace('.'.$file_info->getExtension(), '', $file);
//                if($index != '3_4') continue;
                    $type_code = $index{0};
                    switch($type_code)
                    {
                        case 3:
                            $txt_path = $pose_path.$index.'.txt';
                            $entity_type = 'clouds';
                            if(file_exists($txt_path))
                            {
                                $f = fopen($txt_path, FOPEN_READ);
                                $text = fread($f, filesize($txt_path));
                                fclose($f);
                                $text_array = [];
                                foreach($this->languages as $lang => $id)
                                {
                                    $text_array[] = ['language_id' => $id, 'text' => (($lang == 'ru') ? $text : null)];
                                }
                                $result[$entity_type][$index]['text']= $text_array;
                            }
                            else
                            {
                                continue; // For multi-languages
                            }
                            break;
                        default:
                            $entity_type = 'arrows';
                            $result[$entity_type][$index]['type']= $this->arrows_map[$type_code]['type'];
                            $result[$entity_type][$index]['direction']= $this->arrows_map[$type_code]['direction'];
                            break;

                    }
                    foreach((array) $xml->dict->key as $key => $value)
                    {
                        $transformation = [];
                        $real = (array) $xml->dict->dict[$key]->real;
                        foreach((array) $xml->dict->dict[$key]->key as $k => $v)
                        {

                            $transformation[$v] = $real[$k];
                        }
                        $result[$entity_type][$index][$value]= $transformation;

                    }

                }

            }
            $data[$pose_id] = $result;

        }
        closedir($folder_data);
        foreach($data as $p_id => $row)
        {
            if(array_key_exists('clouds', $row))
            {
                foreach($row['clouds'] as $cloud)
                {
                    $cloud_record = ['pose_id' => $p_id];
                    $transformation_record = [];
                    $transformation_record['rotate'] = $this->transform_model->add($cloud['rotate']);
                    $transformation_record['translate'] = $this->transform_model->add($cloud['translate']);
                    $transformation_record['scale'] = $this->transform_model->add($cloud['scale']);
                    $cloud_record['transformation_id'] = $this->transformations_model->add($transformation_record);
                    $cloud_id = $this->clouds_model->add($cloud_record);
                    $this->cloud_texts_model->insert_batch($cloud_id, $cloud['text']);
                }
            }
            if(array_key_exists('arrows', $row))
            {
                foreach($row['arrows'] as $arrow)
                {
                    $arrow_record = [
                        'pose_id' => $p_id,
                        'direction' => $arrow['direction'],
                        'type' => $arrow['type']
                    ];
                    $transformation_record = [];
                    $transformation_record['rotate'] = $this->transform_model->add($arrow['rotate']);
                    $transformation_record['translate'] = $this->transform_model->add($arrow['translate']);
                    $transformation_record['scale'] = $this->transform_model->add($arrow['scale']);
                    $arrow_record['transformation_id'] = $this->transformations_model->add($transformation_record);
                    $this->arrows_model->add($arrow_record);
                }
            }
        }

        return $data;
    }

    protected function process_archive_d($device_id, $uploaded_zip, $filename, $category = null)
    {
        ini_set("memory_limit","512M");
        set_time_limit(0);
        /** @var  $device Application\Models\Entities\Devices */
        $device = $this->em->find('Application\Models\Entities\Devices', $device_id);
        $first_time = false;
        if(!$category)
        {
            $category = new Application\Models\Entities\PosesCategories();
            $category->setLastUpdate(new DateTime('now'));
            $this->em->persist($category);
            $this->em->flush($category);
            $first_time  = true;
        }
        $category_id = $category->getId();
        $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/';
        $archives_folder = $_SERVER['DOCUMENT_ROOT'].'/assets/archives/';
        $destination_folder = $archives_folder.$category_id.'/'.$device_id.'/';
//        $uploaded_zip = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/'.$filename;
        if(!is_dir($destination_folder))
        {
            mkdir($destination_folder, 0777, true);
        }
        $zip_file = $destination_folder.time().'.zip';
//        copy($uploaded_zip, $zip_file ); // Change to move_uploaded_file!!!
        move_uploaded_file($uploaded_zip, $zip_file);
        $zip = new ZipArchive;
        $res = $zip->open($zip_file);
        if(!$res)
        {
            throw new Exception('ZIP file opening error!', 500);
        }
        $folder = $targetFolder . str_replace('.zip', '_'.$device_id, $filename);
        if(is_dir($folder))
        {
            $folder .= time();
        }
        $folder .= '/';
        mkdir($folder, 0777, true);
        $extracted = $zip->extractTo($folder);
        $zip->close();
        if(!$extracted)
        {
            throw new Exception('ZIP extracting error!', 500);
        }
        if($first_time)
        {
            $folder_data = opendir($folder);
            while (($category_folder = readdir($folder_data)) !== false) {
                if(filetype($folder . $category_folder) == 'dir' && !in_array($category_folder, ['..', '.', '...']))
                {
                    $category_name = ucfirst(str_replace('_', ' ', $category_folder));
                    $category->setTitles($this->generate_titles_collection($category, $category_name));
                    $this->em->persist($category);
                    if(is_dir($folder . $category_folder.'/data'))
                    {
                        $this->process_pose_d($folder . $category_folder, $category, $device);
                    }
                    else
                    {
                        $subs = [];
                        $category_data = opendir($folder . $category_folder);
                        while (($subcategory_folder = readdir($category_data)) !== false) {
                            if(filetype($folder . $category_folder.'/'.$subcategory_folder) == 'dir' && !in_array($subcategory_folder, ['..', '.', '...']))
                            {
                                $sub_category = new Application\Models\Entities\PosesCategories();
                                $sub_category->setLastUpdate(new DateTime('now'));
                                $sub_category->setParentId($category_id);
                                $sub_category->setParent($category);
                                $sub_category->setTitles($this->generate_titles_collection($sub_category, ucfirst(str_replace('_', ' ', $subcategory_folder))));
                                $this->em->persist($sub_category);
                                $this->em->flush($sub_category);
                                $this->process_pose_d($folder . $category_folder.'/'.$subcategory_folder, $sub_category, $device);
                                $subs[] = $sub_category;
                            }

                        }
                        $category->setChildren(new \Doctrine\Common\Collections\ArrayCollection($subs));
                    }
                }
            }
            closedir($folder_data);
        }
        else
        {
            if(!$category->getChildren() || !$category->getChildren()->count())
            {
                $this->process_category($folder, $category, $device);
            }
            else
            {
                $subfolder = $folder.$this->get_category_folder($category).'/';
                /** @var  $subcategory Application\Models\Entities\PosesCategories */
                foreach($category->getChildren() as $subcategory)
                {

                    $this->process_category($subfolder, $subcategory, $device);
                }
            }
        }
        chmod($folder, 0777);

//        try
//        {
//            unlink($folder);
//        }
//        catch (Exception $e)
//        {
//            // Do nothing
//        }
//        $response = [
//            'category_name' => $category_name,
//            'subcategories' => $subcategories_count,
//            'poses' => $poses_count
//        ];
        $this->em->flush();
        return $category;
    }

    private function process_pose_d($folder, Application\Models\Entities\PosesCategories $category, Application\Models\Entities\Devices $device)
    {
        $poses = 0;
        $images_folder = $_SERVER['DOCUMENT_ROOT'].'/assets/images/';
        $folder .= '/';
        chmod($folder, 0777);
        $data_folder = $folder.'data/tips_data/';
        $circuits_folder = $folder.'data/circuit/';
        $photo_folder = $folder.'photo/';
        if(!is_dir($data_folder) || !is_dir($photo_folder))
        {
            throw new Exception ('Wrong Archive structure', 400);
        }
        $folder_data = opendir($data_folder);
        while (($pose_folder = readdir($folder_data)) !== false)
        {
            $pose_path = $data_folder . $pose_folder;
            if(filetype($pose_path) != 'dir' || in_array($pose_folder, ['..', '.', '...']))
            {
                continue;
            }

            $pose_path .= '/';
            $pose_data = opendir($pose_path);
            $pose = new Application\Models\Entities\Poses();
            $pose->setCategory($category);
            $pose->setDevice($device);
            $pose_image_variants = [
                $photo_folder.$pose_folder.'@2x'.$this->photo_extension,
                $photo_folder.$pose_folder.'@3x'.$this->photo_extension,
                $photo_folder.$pose_folder.$this->photo_extension
            ];
            $pose_image = null;
            foreach($pose_image_variants as $im)
            {
                if(file_exists($im))
                {
                    $pose_image = $im;
                    break;
                }
            }
            if(is_null($pose_image))
            {
                throw new Exception (sprintf(lang('pose_picture_error'), $pose_folder), 400);
            }
            $this->em->persist($pose);
            $this->em->flush($pose);
            $pose_id = $pose->getId();
            $pose_photo_path = $images_folder.'poses/'.$pose_id.'/';
            $device_id = $device->getId();
            if(!is_dir($pose_photo_path))
            {
                mkdir($pose_photo_path, 0777, true);
            }
            rename($pose_image, $pose_photo_path.'main_'.$device_id.$this->photo_extension);
            $exploded_name = explode('-', $pose_folder);
            $circuit_name = $exploded_name[0].'-'.$exploded_name[1].'-c-'.$exploded_name[2];
            $circuit_image_variants = [
                $circuits_folder.$circuit_name.'@2x'.$this->circuit_extension,
                $circuits_folder.$circuit_name.'@3x'.$this->circuit_extension,
                $circuits_folder.$circuit_name.$this->circuit_extension
            ];
            $circuit_image = null;
            foreach($circuit_image_variants as $im)
            {
                if(file_exists($im))
                {
                    $circuit_image = $im;
                    break;
                }
            }
            if(!is_null($circuit_image))
            {
                rename($circuit_image, $pose_photo_path.'circuit_'.$device_id.$this->circuit_extension);
            }
            while(($file = readdir($pose_data)) !== false)
            {
                $file_info = new SplFileInfo($file);

                if($file_info->getExtension() == 'plist')
                {
                    $xml = simplexml_load_file($pose_path.$file);
                    $index = str_replace('.'.$file_info->getExtension(), '', $file);
                    $type_code = $index{0};
                    switch($type_code)
                    {
                        case 3:
                            $txt_path = $pose_path.$index.'.txt';
                            $entity = new Application\Models\Entities\Clouds();
                            if(file_exists($txt_path))
                            {
                                $f = fopen($txt_path, FOPEN_READ);
                                $cloud_text = fread($f, filesize($txt_path));
                                fclose($f);
                                /** @var  $language Application\Models\Entities\Languages*/
                                foreach($this->languages_d as $language)
                                {
                                    $text = new Application\Models\Entities\CloudTexts();
                                    $text->setCloud($entity);
                                    $text->setLanguage($language);
                                    $text->setText((($language->getCode() == 'en') ? $cloud_text : null));
                                    $this->em->persist($text);
                                }
                            }
                            else
                            {
                                continue; // For multi-languages
                            }
                            break;
                        default:
                            $entity = new Application\Models\Entities\Arrows();
                            $entity->setDirection($this->arrows_map[$type_code]['direction']);
                            $entity->setType($this->arrows_map[$type_code]['type']);
                            break;

                    }
                    $entity->setPose($pose);
                    $transformation = new Application\Models\Entities\Transformations();
                    foreach((array) $xml->dict->key as $key => $value)
                    {
                        $transform = new Application\Models\Entities\Transform();
                        $real = (array) $xml->dict->dict[$key]->real;
                        foreach((array) $xml->dict->dict[$key]->key as $k => $v)
                        {
                            $f = 'set' . ucfirst($v);
                            $transform->$f($real[$k]);
                            $this->em->persist($transform);
                            $ft = 'set' . ucfirst($value);
                            $transformation->$ft($transform);
                        }
                    }
                    $this->em->persist($transformation);
                    $entity->setTransformation($transformation);
                    $this->em->persist($entity);
                }

            }
            $poses++;
        }
        closedir($folder_data);

        return $poses;
    }

    private function generate_titles_array($category_id, $category_title)
    {
        $r = [];
        foreach($this->languages as $lang => $id)
        {
            $r[] = [
                'language_id' => $id,
                'title' => (($lang == 'ru') ? $category_title : null),
                'category_id' => $category_id
            ];
        }
        return $r;
    }

    private function generate_titles_collection($category, $category_title)
    {
        $r = [];
        /** @var  $language Application\Models\Entities\Languages*/
        foreach($this->languages_d as $language)
        {
            $text = new Application\Models\Entities\PosesCategoriesTexts();
            $text->setLanguage($language);
            $text->setTitle((($language->getCode() == 'en') ? $category_title : null));
            $text->setCategory($category);
            $this->em->persist($text);
            $r[] = $text;
        }

        return new \Doctrine\Common\Collections\ArrayCollection($r);
    }

    private function process_category($folder, Application\Models\Entities\PosesCategories $category, Application\Models\Entities\Devices $device)
    {

        /** @var  $category_title Application\Models\Entities\PosesCategoriesTexts */
        $category_folder = $this->get_category_folder($category);
        if(!is_dir($folder . $category_folder.'/data'))
        {
            throw new Exception(lang('zip_structure_error'), 400);
        }
        $this->process_pose_d($folder . $category_folder, $category, $device);
    }

    private function get_category_folder(Application\Models\Entities\PosesCategories $category)
    {
        $category_folder = '';
        foreach($category->getTitles() as $category_title)
        {
            if($category_title->getLanguage()->getCode() == 'en')
            {
                $category_folder = strtolower(str_replace(' ', '_', $category_title->getTitle()));
            }

        }
        return $category_folder;
    }
}
