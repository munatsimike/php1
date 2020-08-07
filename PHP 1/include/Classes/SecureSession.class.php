<?php
// set cookie parameters
 class SecureSession{
   private  $lifetime;
   private  $path;
   private $domain;
   private  $secure;
   private $httpOnly;

   public function __construct($lifetime,$path,$domain,$secure,$httpOnly){
     $this->lifetime = $lifetime;
     $this->path = $path;
     $this->domain=$domain;
     $this->secure =$secure;
     $this->$httpOnly = $httpOnly;
   }
   // method to Initialize session
 public function SessionStart(){
   session_set_cookie_params($this->lifetime,$this->path,$this->domain,$this->secure,$this->httpOnly);
   session_start();
 }

 }
 ?>
