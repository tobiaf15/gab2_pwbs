<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mmahasiswa extends CI_Model {

    // buat method untuk tampil data
    function get_data() 
    {
        // kalau cuma 1 field
        // $this->db->from("npm");   

        // kalau * from
        // $this->db->from("tb_mahasiswa");   
        // $this->db->order_by("npm", "DESC");
        
        // keamanan di database menggunakan alias pada database
        $this->db->select("
            id AS id_mhs,
            npm AS npm_mhs,
            nama AS nama_mhs,
            telepon AS telepon_mhs,
            jurusan AS jurusan_mhs
        ");

        $this->db->from("tb_mahasiswa");   
        $this->db->order_by("npm", "DESC");

        $query = $this->db->get()->result();
        return $query;
    }

    function delete_data($token)
    {
        // check apakah npm ada / tidak
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        // $this->db->where("npm = '$token'");
        $this->db->where("TO_BASE64(npm) = '$token'");

        // eksekusi query
        $query = $this->db->get()->result();

        // jika npm ditemukan
        if(count($query) == 1) {
            // $this->db->where("npm = '$token'");
            $this->db->where("TO_BASE64(npm) = '$token'");
            $this->db->delete("tb_mahasiswa");

            // kirim nilai 1
            // $hasil = "Y";
            $hasil = 1;
        } 
        // jika npm tidak ditemukan
        else {
            // kirim nilai hasil 0
            // $hasil = "X";
            $hasil = 0;
        }
        // kirim variabel hasil ke controller mahasiswa
        return $hasil;
    }
    
    // buat fungsi simpan data
    function save_data($npm, $nama, $telepon, $jurusan, $token)
    {
        // check apakah npm ada / tidak
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        // $this->db->where("npm = '$token'");
        $this->db->where("TO_BASE64(npm) = '$token'");

        // eksekusi query
        $query = $this->db->get()->result();

        // jika npm tidak ditemukan
        if(count($query) == 0) {
            // isi nilai untuk masing" field
            $data = array(
                "npm" => $npm,
                "nama" => $nama,
                "telepon" => $telepon,
                "jurusan" => $jurusan,
            );

            // simpan data
            $this->db->insert("tb_mahasiswa", $data);
            $hasil = 0;
        } 
        // jika npm ditemukan
        else {
            $hasil = 1;
        }

        return $hasil;
    }

    // fungsi untuk ubah data
    function update_data($npm, $nama, $telepon, $jurusan, $token)
    {
       // check apakah npm ada / tidak
        $this->db->select("npm");
        $this->db->from("tb_mahasiswa");
        // $this->db->where("npm = '$token'");
        // npm (encode) and npm = npm
        // npm != 22 and npm = 55 (result = 0)
        $this->db->where("TO_BASE64(npm) != '$token' AND npm = '$npm'");

        // eksekusi query
        $query = $this->db->get()->result();

        // jika npm tidak ditemukan
        if(count($query) == 0) {
            
            // isi nilai untuk masing" field
            $data = array(
                "npm" => $npm,
                "nama" => $nama,
                "telepon" => $telepon,
                "jurusan" => $jurusan,
            );

            // updte data
            $this->db->where("TO_BASE64(npm) = '$token'");
            $this->db->update("tb_mahasiswa", $data);
            $hasil = 0;
        } 
        else {
            $hasil = 1;
        }
        
        return $hasil;
    }

}