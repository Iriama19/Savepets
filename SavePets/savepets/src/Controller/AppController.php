<?php
declare(strict_types=1);
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\I18n\I18n;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieCollection;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $idioma=$this->request->getCookie('idiomacookie');
        if ($idioma == 'en_US'){
            I18n::setLocale('es_ES');

        }else{
            I18n::setLocale('en_US');
        }
    
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }


    public function recordActivity(){
        //Datos petición 
        $pages  = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (isset($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : '');
        if($pages !=null && $pages != ''){
            $pages = explode("/",$pages);
            if(sizeof($pages)>=3){
                $action=$pages[2];
            }else{
                $action='index';
            }
        }else{
            $action='index';
        }
        $model=$this->modelClass;
        if(($model=='PublicationAdoption'||$model=='AnimalAdoption'||$model=='AnimalShelter')&& str_contains($action,'view')||$model=='Animal' && str_contains($action,'view')||($model=='Pages')){
            //Datos animal
            if($model=='Animal' && str_contains($action,'view')){
                $id=$pages[3];

                $animal = $this->Animal->get($id, [
                    'contain' => ['AnimalShelter'],
                ]);

                $animalspecie=$animal['specie'];
                $animalchip=$animal['chip'];
                $animalsex=$animal['sex'];
                $animalrace=$animal['race'];
                $animalage=$animal['age'];
                $animalstate=$animal['state'];
            }else{
                if(($model=='PublicationAdoption'||$model=='AnimalAdoption'||$model=='AnimalShelter')&& str_contains($action,'view')){
                    $id=$pages[3];
                    if($model=='PublicationAdoption'){
                        $publicationanimaladoption = $this->PublicationAdoption->get($id, [
                            'contain' => ['Animal'],
                        ]);
                        $animal=$publicationanimaladoption['animal'];
                    }elseif($model=='AnimalAdoption'){
                        $animaladoption = $this->AnimalAdoption->get($id, [
                            'contain' => ['Animal'],
                        ]);
                        $animal=$animaladoption['animal'];
                    }elseif($model=='AnimalShelter'){
                        $animalshelter = $this->AnimalShelter->get($id, [
                            'contain' => ['Animal'],
                        ]);
                        $animal=$animalshelter['animal'];
                    }
                    $animalspecie=$animal['specie'];
                    $animalchip=$animal['chip'];
                    $animalsex=$animal['sex'];
                    $animalrace=$animal['race'];
                    $animalage=$animal['age'];
                    $animalstate=$animal['state'];
                }elseif($model=='Pages'){
                    $animalspecie='';
                    $animalchip='';
                    $animalsex='';
                    $animalrace='';
                    $animalage='';
                    $animalstate='';
                }
            }

            //Datos usurario 
            $currentLogedusername=$this->request->getAttribute('identity')['username'];
            $currentLogedID=$this->request->getAttribute('identity')['id'];

            $currentLogedAddressID=$this->request->getAttribute('identity')['addres_id'];
            $allAddress = $this->getTableLocator()->get('Address');
            $allAddressIDCity = $allAddress->find()->where(['id'=> $currentLogedAddressID])->select('city')->first();
            $allAddressIDProvince = $allAddress->find()->where(['id'=> $currentLogedAddressID])->select('province')->first();
            $allAddressIDPostalCode = $allAddress->find()->where(['id'=> $currentLogedAddressID])->select('postal_code')->first();
            $allAddressIDCountry = $allAddress->find()->where(['id'=> $currentLogedAddressID])->select('country')->first();
            if($allAddressIDCountry!=NULL){
                $usercountry=$allAddressIDCountry['country'];
                $userprovince=$allAddressIDProvince['province'];
                $usercity=$allAddressIDCity['city'];
                $userpostalcode=$allAddressIDPostalCode['postal_code'];
                //Edad
                $currentbirtdate=(array) $this->request->getAttribute('identity')['birth_date'];
                $birth=$currentbirtdate['date'];
            
                $now = date("Y-m-d");
                $diff = date_diff(date_create($birth), date_create($now));
                $age=intval($diff->format('%y'));

                //Caracteristicas
                $allFeaturesUser = $this->getTableLocator()->get('FeatureUser');
                $workuser = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>1])->select('value')->first();
                $studiesuser = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>2])->select('value')->first();
                $maritalstatususer = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>3])->select('value')->first();
                $childrenuser = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>4])->select('value')->first();
                $housinguser = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>5])->select('value')->first();
                $otherpetsuser = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>6])->select('value')->first();
                $numpetsuser = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>7])->select('value')->first();
                $gender = $allFeaturesUser->find()->where(['user_id'=> $currentLogedID, 'feature_id'=>8])->select('value')->first();

                $work=$workuser['value'];
                $studies=$studiesuser['value'];
                $maritalstatus=$maritalstatususer['value'];
                $children=$childrenuser['value'];
                $housing=$housinguser['value'];
                $otherpet=$otherpetsuser['value'];
                $numpets=$numpetsuser['value'];

                //Número comentarios
                $Comments = $this->getTableLocator()->get('Comment');
                $comentuser = $Comments->find('all')->where(['user_id '=>$currentLogedID]);
                $numcomment=$comentuser->count();

                //Número publicaciones
                //Adoption
                $PublicationAdoptions = $this->getTableLocator()->get('PublicationAdoption');
                $PublicationAdoptionuser = $PublicationAdoptions->find('all')->where(['user_id '=>$currentLogedID]);
                $numPublicationAdoptionuser=$PublicationAdoptionuser->count();

                //Help
                $PublicationHelps = $this->getTableLocator()->get('PublicationHelp');
                $PublicationHelpuser = $PublicationHelps->find('all')->where(['user_id '=>$currentLogedID]);
                $numPublicationHelpuser=$PublicationHelpuser->count();

                //Stray
                $PublicationStrays = $this->getTableLocator()->get('PublicationStray');
                $PublicationStraysuser = $PublicationStrays->find('all')->where(['user_id '=>$currentLogedID]);
                $numPublicationStraysuser=$PublicationStraysuser->count();

                //Total
                $numpublication=$numPublicationAdoptionuser+$numPublicationHelpuser+$numPublicationStraysuser;
                //Crear/Guardar en csv
                if(file_exists('history.csv')){
                    $list = [[$model,$currentLogedusername,$usercountry,$userprovince,$usercity,$userpostalcode,$numpublication,$numPublicationAdoptionuser,$numPublicationHelpuser,$numPublicationStraysuser,$numcomment,$age,$work,$studies,$maritalstatus,$children,$housing,$otherpet,$numpets,$gender,$animalspecie,$animalchip,$animalsex,$animalrace,$animalage,$animalstate]];
                    $historico= fopen('history.csv','a');
                }else{

                    //array con todo lo que se va añadir en csv
                    $list = [['Model','Username','User_Country','User_Province','User_City','User_PostalCode','Numpublication','NumPublicationAdoption','NumPublicationHelp','NumPublicationStray','NumComment','UserAge','Work','Studies','Marital Status','Children','Housing','Other Pets','NumPets','Gender','Specie','Chip','Sex','Race','Age','State']
                                ,[$model,$currentLogedusername,$usercountry,$userprovince,$usercity,$userpostalcode,$numpublication,$numPublicationAdoptionuser,$numPublicationHelpuser,$numPublicationStraysuser,$numcomment,$age,$work,$studies,$maritalstatus,$children,$housing,$otherpet,$numpets,$gender,$animalspecie,$animalchip,$animalsex,$animalrace,$animalage,$animalstate]];
                    $historico= fopen('history.csv','w');
                }
                foreach($list as $fields){
                    fputcsv($historico,$fields);
                }
                fclose($historico);
            }
        }
    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {        
        if($this->Authentication->getIdentity()){
            $this->recordActivity();
        }
        parent::beforeFilter($event);

        // for all controllers in our application, make index and view
        // actions public, skipping the authentication check
        $this->Authentication->addUnauthenticatedActions(['login','home','display','changeLang']);
        
        $nummessage = $this->numeroMensajes();
        $this->set('nummessage',$nummessage);
    }
    


    public function numeroMensajes(){
        if($this->Authentication->getIdentity()){
            $currentLogedID=$this->request->getAttribute('identity')['id'];

            $Messages = $this->getTableLocator()->get('Message');
            $nummessage = $Messages->find('all')->where(['receiver_user_id' => $currentLogedID, 'readed' => 'No'])->count();
            return($nummessage);
        }
    }

    public function changeLang():void
    {
        $idioma=$this->request->getCookie('idiomacookie');
        if (I18n::getLocale() !== 'es_ES'){#No esta en español

                I18n::setLocale('es_ES');#Pongo inglés
                $idioma = Cookie::create('idiomacookie', 'en_US');#Cambio cookie
                $this->response = $this->response->withCookie($idioma);
                $this->idiomacookie = 'en_US';

            }else{
                I18n::setLocale('en_US');
                $idioma = Cookie::create('idiomacookie', 'es_ES');
                $this->response = $this->response->withCookie($idioma);
                $this->idiomacookie = 'es_ES';
        }
        $this->redirect($this->referer());
        
    }
}
