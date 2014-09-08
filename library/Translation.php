<?php

/**
 * Description of Translation
 *
 * Translate words between languages
 * 
 * @author wallrio
 * @email wallrio@gmail.com
 */


/*
 *  @method go( Source = STRING , goSimilar = INTEGER , showSimilar = BOOLEAN , langaguePrefixFrom = STRING, langaguePrefixTo = STRING)
 *  @return words translated
 * 
 *  goSimilar = translates the similar word set according to the number
 *  showSimilar = instead of translating, show similarities
 * 
 *  @example go('be welcome',0,false,'en','ptbr')
 *  @return 'seja bem vindo'
 * 
 *  reserved character:
 *  ~ = blocks the translate of words
 *  @example ~wellcome
 *  @return wellcome
 * 
 */


/*
 *  @method goSimilar( Source = STRING )
 *  @return words similar
 * 
 *  @example goSimilar('home')
 *  @return 'casa,inicio,residência'
 * 
 */

namespace WallRio\Solo;

class Translation {
    private $languageDir            = "languages/";
    private $xml                    = null;
    private $delimit                = ' ';
    private $defaultLanguage        = 'en';
    private $langaguePrefixTo         = null;
    private $langaguePrefixFrom         = null;
    private $langagueDefaultPrefix    = null;
    private $langagueNameTo         = null;
    private $langagueNameFrom         = null;
    private $langagueDefaultName    = null;
    private $pathFullLanguage       = null;
    private $fileLanguagePrefix     = '.xml';
    private $xmlLanguageDefault     = null;
    private $xmlLanguageSource      = null;
    private $xmlLanguageDestination = null;
    private $listLanguages = null;
    
    private $ucfirst = false;
    private $ucwords = false;
    
    function __construct($langaguePrefixFrom = null,$langaguePrefixTo = null) {

	echo "translation...";
	$className = str_replace(__NAMESPACE__ . '\\','',get_class($this));
	$classNamelower = strtolower($className);

       $this->languageDir = __DIR__ .DIRECTORY_SEPARATOR.$classNamelower.DIRECTORY_SEPARATOR. $this->languageDir;	
       $langaguePrefixFrom = empty($langaguePrefixFrom)?$this->defaultLanguage:$langaguePrefixFrom;
       $langaguePrefixTo = empty($langaguePrefixTo)?$this->defaultLanguage:$langaguePrefixTo;
       
       $this->setLanguageFrom($langaguePrefixFrom);            
       $this->setLanguageTo($langaguePrefixTo);                   
       $this->cacheLanguageDefault();   
       
      
       // cria um array com as linguagens disponiveis na pasta config/labels
       if ($handle = opendir($this->languageDir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {                                                                       
                    $xmlgetname = simplexml_load_file($this->languageDir.DS.$entry);                                      
                    $prefix = str_replace($this->fileLanguagePrefix,'',$entry);                   
                    $this->listLanguages['name'][] =(string) $xmlgetname->name;
                    $this->listLanguages['prefix'][] =(string) $prefix;
                }
            }
            closedir($handle);
        }

       
    }
    
    public function listLanguages(){
        return $this->listLanguages;
    }
    
    public function setLanguageTo($langaguePrefix = null){
         if(isset($langaguePrefix))
         $this->langaguePrefixTo = $langaguePrefix; 
         $this->cacheLanguageDestination($langaguePrefix);         
    }
    
    public function setLanguageFrom($langaguePrefix = null){
         if(isset($langaguePrefix))
         $this->langaguePrefixFrom = $langaguePrefix; 
         $this->cacheLanguageSource($langaguePrefix);         
    }
    
    public function getLanguageTo(){         
         return $this->langagueNameTo; 
    }
    
    public function stylefont($string){
        preg_match_all('/([^:|;][a-z-AZ0-9]+):([a-z]+)/i',$string,$macth2);                   
            
            foreach($macth2[1] as $index=>$style){
               
                   
                if($style == 'ucfirst'){
                    if($macth2[2][$index] == 'true'){
                        $this->ucfirst = true;
                    }
                }
                if($style == 'ucwords'){                    
                    if($macth2[2][$index] == 'true'){                       
                        $this->ucwords = true;                        
                    }
                }
            }
                    
    }
    
    // show words similar
    public function goSimilar($strSource){
        if($this->go($strSource,false,true))         
            return $this->go($strSource,false,true);
        return false;
    }
    // translating the word or phrase to according language defined
    public function go($strSource,$goSimilar = false,$showSimilar = false,$langaguePrefixFrom = null,$langaguePrefixTo = null){        
        $strTranslated=null;

        $langaguePrefixFrom = empty($langaguePrefixFrom)?$this->langaguePrefixFrom:$langaguePrefixFrom;
        $langaguePrefixTo = empty($langaguePrefixTo)?$this->langaguePrefixTo:$langaguePrefixTo;


        $this->setLanguageFrom($langaguePrefixFrom);            
        $this->setLanguageTo($langaguePrefixTo);                   
     
         
        // cria um array com todas as palavras delimitadas      
        $strSourceArray = preg_split('/([ ])/i', $strSource, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
     
        
        foreach($strSourceArray as $string){                        
            $string = str_replace($this->delimit,'',$string);            
            if($string == '~' ){
                $strTranslated .= $string.$this->delimit;
                continue;
            }          
            /* antes de traduzir é lido o cache do arquivo default para capturar a palavra universal para usar como base para a tradução
            * ex: para traduzir a palavra casa do portugues para o françes, primeiro é traduzido a palavra casa para o ingles, e depois
            * é traduzido a palavra home para o françes, sendo assim, o ingles é a linguagem intermediatria para a tradução
            */            
            $string_sourceDefault = $this->ReaderSource($string,true);
            
                if(preg_match_all('/~[~]+[^~]+/i',$string,$match)){     
                    
                    if(strpos($match[0][0],'~~') !== false){
                        $palavraSource = str_replace('~', '', $match[0][0]);
                        
                        $sinal = substr($match[0][0],1);
                        $sinal = str_replace($palavraSource, '', $sinal);
                    }else{                        
                        $palavraSource = str_replace('~:', '', $match[0][0]);                                             
                        $sinal = substr($match[0][0],1);
                        $sinal = str_replace($palavraSource, '', $sinal);
                    }
                   
                    if(preg_match_all('/(~+)([^~].*)/i',$string,$macth2) ){                    
                        $string = $macth2[2][0];
                        $string2 = $macth2[1][0];
                    }    
                   
                    
                    $sinalForce = '';
                    for($i=0;$i<floor(strlen($string2)/2);$i++){
                        $sinalForce .= '~';
                    }
                    if(strlen($string2)%2!=0){
                        $string = preg_replace('/~[~]+/i', '', $string);             
                        $string_sourceDefault = $string;
                        $strTranslated .= $sinalForce.''.$string_sourceDefault.$this->delimit;
                    }else{                                               
                        $string_sourceDefault = $this->ReaderSource($string,true);     
                        $string_sourceDefault = $this->ReaderDestination($string_sourceDefault,false,$goSimilar,$showSimilar);                       
                        $strTranslated .= $sinalForce.''.$string_sourceDefault.$this->delimit;
                    }
                                     
                }else{                
                    
                    if($string_sourceDefault == false){
                        $string = preg_replace('/~/i', '', $string);
                         $strTranslated .= $string.$this->delimit;    
                    }else{
                        $strTranslated .= $this->ReaderDestination($string_sourceDefault,false,$goSimilar,$showSimilar);
                    }
                }            
        }       
        
        if($this->ucfirst == true)
            $strTranslated = ucfirst($strTranslated);
        
        if($this->ucwords == true)
            $strTranslated = ucwords($strTranslated);
        
        return $strTranslated;
    }
    
    
    // reads the xml file from source and search for the word to translate
    private function ReaderSource($value, $showAttr = false){ 
        $sinal = "";
        if(strpos($value,':')!==-1){
            preg_match_all('/[^a-zA-ZÀ-Úà-ú ~]/i',$value,$match) ;
                    
            if(preg_match_all('/~[~]+[^~]+/i',$value,$match)){          
                if(isset($match[0][0])){
                     $sinal = $match[0][0];
                    }
                $value = preg_replace('/[^a-zA-ZÀ-Úà-ú]/i', '', $value);
            }
        }
        
        if($this->xmlLanguageSource){        
            $this->langagueNameFrom = $this->xmlLanguageSource->name;
            foreach($this->xmlLanguageSource->string as $string) {
                    if($showAttr == false){
                        if( strtolower($value) == strtolower($string['name']) ) {                        
                             return $sinal.$string;
                        }                
                    }else{                                                
                        if( strtolower($value) == strtolower($string) ) {                                                          
                            return $sinal.$string['name'];
                        }         
                    }
            }
            return false;
        }else{
                return $sinal.$value;
        }
    }
    
    // reads the xml file from destination and search for the word to translate
    private function ReaderDestination($value, $showAttr = false,$goSimilar = false,$showSimilar = false){      
        if($this->xmlLanguageDestination){    
            $this->langagueNameTo = $this->xmlLanguageDestination->name;
            foreach($this->xmlLanguageDestination->string as $string) {
                    if($showAttr == false){                       
                        if( strtolower($value) == strtolower($string['name']) ) {     
                            if($showSimilar == false){
                                if($goSimilar != false){
                                    $similar_array = explode(',',$string['similar']);
                                    if(isset($similar_array[$goSimilar-1]))
                                       return $similar_array[$goSimilar-1];

                                    return $string;
                                }else{
                                   return $string;
                                }
                            }else{
                                return $string['similar'];
                            } 
                        }   
                        
                    }else{
                        if( strtolower($value) == strtolower($string) ) {                        
                             return $string['name'];
                        }                
                    }
            }
            return false;
        }else{
                return $value;
        }
    }
    

    // faz cache do arquivo da linguagem default
    private function cacheLanguageDefault(){
                $file = $this->languageDir.$this->defaultLanguage.$this->fileLanguagePrefix;
                if(file_exists($file)){
                    $this->xmlLanguageDefault = simplexml_load_file($file);    
                    $this->langagueDefaultName = $this->xmlLanguageDefault->name;
                    $this->langagueDefaultPrefix = $this->defaultLanguage;
                    
                }                    
    }
    
    // faz cache do arquivo da linguagem origem
    private function cacheLanguageSource($language){            
                $language = empty($language)?$this->defaultLanguage:$language;                       
                $file = $this->languageDir.$language.$this->fileLanguagePrefix;
                
                if(!file_exists($file))                                    
                       $file = $this->languageDir.$this->defaultLanguage.$this->fileLanguagePrefix;
                                
                $this->xmlLanguageSource = simplexml_load_file($file);                 
    }
   
    // faz cache do arquivo da linguagem destino
    private function cacheLanguageDestination($language){            
                $language = empty($language)?$this->defaultLanguage:$language;                       
                $file = $this->languageDir.$language.$this->fileLanguagePrefix;
                
                if(!file_exists($file))                                    
                       $file = $this->languageDir.$this->defaultLanguage.$this->fileLanguagePrefix;
                                
                $this->xmlLanguageDestination = simplexml_load_file($file);                                                                                                      
    }
    
    
    
    
    
    
    
}
