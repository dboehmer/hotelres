<?php
/*
 *      statusmsgs.inc
 *      
 *      Copyright 2010 Daniel Böhmer <daniel.boehmer@it2007.ba-leipzig.de> and
 *                     Patrick Nicolaus <patrick.nicolaus@it2007.ba-leipzig.de>
 *      
 *      This file is part of Hotelres.
 * 
 *      Hotelres is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      Hotelres is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

$counter=0;
$messages;
$priorities=array("info", "warn", "error");





function messages_add($text, $priority="info")
    {
        global $messages, $new_id;
        static $new_id;
        
        $new_id++;
        
        if ($text=="")
            {
                return false;
            }
        
        $messages[$priority][$new_id] = $text;
        
        return $new_id;
    }

function messages_delete($id)
    {
        global $messages;
        
        print_r($messages);
        
        // cycle through all message stacks
        foreach ($messages as $priority => $stack)
            {
                if (key_exists($id, $stack))
                    {
                        // id found -> delete message
                        echo "YEAH";
                        unset($messages[$priority][$id]);
                        return true;
                    }
            }
            
            // message id not found
            return false;
    }

function messages_show()
    {
        global $messages;
        
        if ($messages)
            {
                foreach ($messages as $priority => $stack)
                    {
                        foreach ($stack as $id => $text)
                            {
                                echo "<div class='$priority'>$text</div>\n";
                            }
                    }
                return true;
            }
        else
            {
                return false;
            }
    }


?>
