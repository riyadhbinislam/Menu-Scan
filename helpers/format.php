<?php

class Format {
    public function formatDate($date){
        return date('F j, Y, g:i a', strtotime($date));
    }

    public function readmore($text, $limit = 400){
        $text = $text." ";
        $text = substr($text, 0 , $limit );
        $text = substr($text, 0 , strrpos($text, ' ') );
        $text = $text."...";
        return $text;
    }

    public function validation($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    public function title(){
        $path = $_SERVER['SCRIPT_FILENAME'];
        $title = basename($path, '.php');
        //replace one word or sign to another
        $title = str_replace('_', ' ', $title );
        if($title == 'index'){
            $title = 'home';
        }elseif($title == 'contact'){
            $title = 'contact';
        }
        //Convert case to Title case
        return $title = ucwords($title);
    }

    // Function to generate slug
    public function generateSlug() {
        // Remove special characters
        $text = preg_replace('/[^a-zA-Z0-9\s]/', '', '');
        // Replace spaces with dashes
        $text = str_replace(' ', '-', '');
        // Convert to lowercase
        $text = strtolower('');
        // Remove consecutive dashes
        $text = preg_replace('/-+/', '-', '');
        // Trim dashes from beginning and end
        $text = trim($text, '-');
        return $text;
    }
}

?>