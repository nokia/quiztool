<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of LDAPConnection
 *
 * @author alfoldi
 */
class LDAPConnection {

    //put your code here

    protected $ldaphost = "";
    protected $ldapconn = "";
    protected $organization = "";
    protected $user_id = "";
    protected $user_pwd = "";
    protected $entries = "";

    public function __construct($username, $password) {
        $this->ldaphost = "your LDAP url goes here";
        $this->ldapconn = ldap_connect($this->ldaphost);
        ldap_set_option($this->ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldapconn, LDAP_OPT_REFERRALS, 0);
        $this->organization = "o=NSN";
        $this->user_id = "uid=" . $username;
        $this->user_pwd = $password;
    }

    public function is_ldap_connected() {
        $auth = false;
        if ($this->ldapconn) {
            // search the user
            $result = ldap_search($this->ldapconn, $this->organization, $this->user_id);
            $this->entries = ldap_get_entries($this->ldapconn, $result);

            // if user info found
            if ($this->entries['count'] != 0) {

                // check password
                $ldapbind = @ldap_bind($this->ldapconn, $this->entries[0]['dn'], $this->user_pwd);

                if ($ldapbind) {
                    $auth = true;
                }
            }
            // close connection.
            ldap_close($this->ldapconn);
        }
        return $auth;
    }

    public function get_firstname() {
        return explode(" ", trim($this->entries[0]["cn"][0]))[1];
    }

    public function get_lastname() {
        return explode(" ", trim($this->entries[0]["cn"][0]))[0];
    }

    public function get_email_addresse() {
        return $this->entries[0]["nsnprimaryemailaddress"][0];
    }
    
    public function get_user_id(){
        return $this->user_id;
    }

}
