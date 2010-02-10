<?php
/*
 *      usermgmt.php
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


$PAGE_TITLE='Benutzerverwaltung';
$PAGE_HEADLINE='Benutzer hinzufügen, ändern und entfernen';

include('include/header.inc');

$id=$_POST['id'];
if (is_numeric($id))
    {
        $user=good_query_value("SELECT username FROM users WHERE id=".$id);
    }

if ($_POST['action'])
    {
        $action=$_POST['action'];
        
        if ($action=="passwd" && $id="myown")
            {
                $id=$_SESSION['id'];
                for ($i=0; $i<=2; $i++)
                    $password[$i]=$_POST["password$i"];
                
                $password_hash=good_query_value("SELECT password FROM users WHERE id=".$id);
                $password_salt=good_query_value("SELECT salt FROM users WHERE id=".$id);
                
                if (sha1($password[0].$password_salt) != $password_hash)
                    {
                        // user entered wrong old password
                        messages_add("<p>".t("Sie haben Ihr altes Passwort falsch eingegeben!")."</p>", "error");
                    }
                elseif ($password[1] != $password[2])
                    {
                        // user misspelled either password 1 oder 2 of the new pw
                        messages_add("<p>".t("Sie haben Sich beim neuen Passwort vertippt!")."</p>", "error");
                    }
                else
                    {
                        $salt=createSalt();
                        good_query("UPDATE users SET password=SHA1('".$password[2].$salt."'), salt='".$salt."' WHERE id=".$id);
                        messages_add("<p>".t("Passwort geändert!")."</p>", "error");
                    }
            }
        
        else // administrative options only:
        if ($_SESSION['rights'] != "admin")
            {
                messages_add("<p>".t("Sie haben keine Administratorrechte und können keine Benutzer verwalten!")."</p>");
            }
        else switch ($action)
            {
                case "delete":
                    good_query("DELETE FROM users WHERE id=".$_POST['id']);
                    messages_add("<p>".t("Benutzer $user erfolgreich gelöscht.",false,$_POST['id'])."</p>");
                    break;
                case "adduser":
                    $salt=createSalt();
                    good_query("INSERT INTO users (username,password,salt,rights) VALUES('".$_POST['username']."',SHA1('".$_POST['password'].$salt."'),'".$salt."','".$_POST['rights']."')");
                    messages_add("<p>".t("Neuer Benutzer angelegt!")."</p>");
                    break;
                case "passwd":
                    $salt=createSalt();
                    good_query("UPDATE users SET password=SHA1('".$_POST['password'].$salt."'), salt='".$salt."' WHERE id=".$id);
                    messages_add("<p>".t("Passwort geändert!")."</p>");
                    break;
                case "changerights":
                    $rights=$_POST['rights'];
                    good_query("UPDATE users SET rights='".$rights."' WHERE id=".$id);
                    messages_add("<p>".t("Rechte geändert!")."</p>");
            } // switch
    } // if $_POST[action]


// post any messages from the code above
messages_show();


// intro paragraph
echo "<p>".t("Auf dieser Seite können Sie die Benutzer verwalten, die auf das Hotelres-System zugreifen können.")."</p>";


// save rights, used in following tables
$rights=array(
            "guest"   => t("Gast"),
            "manager" => t("Verwalter"),
            "admin"   => t("Administrator"));



// function for listing all rights options (needed several times)
function list_rights($preselected=false)
    {
        global $rights;
        
        foreach ($rights as $right => $desc)
            {
                echo '<option value="'.$right.'"';
                
                // preselect if value equals given preselection
                if ($preselected == $right) echo ' selected="selected"';
                
                echo '>'.$desc.'</option>';
            }
    }


echo "<h3>".t("Eigenes Passwort ändern")."</h3>";

echo '<form action="usermgmt.php" method="post">
    <input type="hidden" name="action" value="passwd">
    <input type="hidden" name="id" value="myown">
    <table>
    <tr><td>'.t("Altes Passwort").':</td><td><input type="password" name="password0"></td></tr>
    <tr><td>'.t("Neues Passwort").':</td><td><input type="password" name="password1"></td></tr>
    <tr><td>'.t("Neues Passwort bestätigen").':</td><td><input type="password" name="password2"></td></tr>
    </table>
    <p><input type="submit" value="'.t("Passwort ändern").'"></p></form>';


if ($_SESSION['rights'] != "admin")
    {
        echo "<p style=\"font-weight:bold;\">".t("Sie haben keine Administratorrechte und können keine Benutzer verwalten!")."</p>";
    }
else
    {
        echo "<h3>".t("Vorhandene Benutzer")."</h3>";

        $users = good_query_table("SELECT id, username, rights FROM users");

        //echo "<pre".print_r($users)."</pre>";

        echo '<table>
        <tr><th>'.t("Benutzername")."</th><th>".t("Rechte")."</th><th>".t("Passwort ändern")."</th><th>".t("Benutzer löschen")."</th></tr>";
        foreach ($users as $user)
            {
                echo "<tr>";
                echo "<td>".$user['username']."</td>";
                if ($user['username']==$_SESSION['username'])
                    {
                        echo "<td>".$rights[$user['rights']]."</td>";
                        echo '<td colspan="2">'.t("Melden Sie sich unter einem anderen Benutzernamen an, um dieses Konto zu ändern.").'</td>';
                    }
                else
                    {
                    echo '<td><form action="usermgmt.php" method="post">
                        <input type="hidden" name="id" value="'.$user['id'].'">
                        <input type="hidden" name="action" value="changerights">
                        <select name="rights">';
                    list_rights($user['rights']);
                    echo '</select>
                        <input type="submit" value="'.t("Ändern").'"></form></td>';
                    echo '<td><form action="usermgmt.php" method="post">
                        <input type="hidden" name="id" value="'.$user['id'].'">
                        <input type="hidden" name="action" value="passwd">
                        <input type="password" value="" name="password">
                        <input type="submit" value="'.t("Ändern").'"></form></td>';
                    echo '<td><form action="usermgmt.php" method="post">
                        <input type="hidden" name="id" value="'.$user['id'].'">
                        <input type="hidden" name="action" value="delete">
                        <input type="submit" value="'.t("Benutzer löschen").'"></form></td>';
                    echo "</tr>";
                }
            }
        echo "</table>";

        echo "<h3>".t("Neuen Benutzer anlegen")."</h3>";

        echo '<form action="usermgmt.php" method="post">
            <input type="hidden" name="action" value="adduser">
            <table>
            <tr><td>'.t("Benutzername").':</td><td><input type="text" name="username"></td></tr>
            <tr><td>'.t("Passwort").':</td><td><input type="password" name="password"></td></tr>
            <tr><td>'.t("Rechte").':</td><td><select name="rights">';
        list_rights();
        echo '</select></td></tr>
            </table>
            <p><input type="submit" value="'.t("Benutzer anlegen").'"></p></form>';
    }

include('include/footer.inc');
?>
