<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(): Response
    {
      /**
      * @Route("/home/index", name="home")
      */
      define("MAX_RESULTS", 1);    
      $searchTerm = "chocolate cake";   
      if (empty($searchTerm))
      {
          $response = array(
          "type" => "error",
          "message" => "Please enter the keyword."
          );
      }
      if(!empty($response)) { 
       $response["type"]; 
       $response["message"]; 
      }                                            
        if (!empty($searchTerm))
        {    
          $apikey = 'AIzaSyCj1WXac3GB4wVd3RKyDm1xyauSLAnoAKg'; 
          $googleApiUrl =  'https://www.googleapis.com/youtube/v3/search?part=snippet&q=recipe' . $searchTerm  . '&maxResults=' . MAX_RESULTS . '&key=' . $apikey;
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HEADER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($ch, CURLOPT_VERBOSE, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          $response = curl_exec($ch);
          curl_close($ch);
          $data = json_decode($response);
          $value = json_decode(json_encode($data), true); 
          
          for ($i = 0; $i < MAX_RESULTS; $i++) {
              $videoId = $value['items'][$i]['id']['videoId'];           
              $video = '<iframe id="iframe" style="width:100%;height:450px" src="//www.youtube.com/embed/' . $videoId . '"data-autoplay-src="//www.youtube.com/embed/' . $videoId . '?autoplay=1"></iframe> ';
         
      }
    }
    return $this->render('home/index.html.twig', [
      'video' => $video,
  ]);
  }
}
