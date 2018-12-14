package com.example.windows10.retrofit.Model;

import com.google.gson.annotations.SerializedName;

public class Wisata {
    @SerializedName("id_wisata")
    private String idWisata;
    @SerializedName("id_kecamatan")
    private String idKecamatan;
    @SerializedName("nama_wisata")
    private String nama_wisata;
    @SerializedName("alamat")
    private String alamat;
    @SerializedName("cp")
    private String cp;
    @SerializedName("deskripsi")
    private String deskripsi;
    @SerializedName("gambar")
    private String gambar;
    private String action;

    public Wisata(String idWisata,String idKecamatan, String nama_wisata, String alamat, String cp, String deskripsi, String gambar, String
            action) {
        this.idWisata = idWisata;
        this.idKecamatan = idKecamatan;
        this.nama_wisata = nama_wisata;
        this.alamat = alamat;
        this.cp = cp;
        this.deskripsi = deskripsi;
        this.gambar = gambar;
        this.action = action;
    }

    public String getIdWisata() {
        return idWisata;
    }

    public void setIdWisata(String idWisata) {
        this.idWisata = idWisata;
    }

    public String getIdKecamatan() { return idKecamatan; }

    public void setIdKecamatan(String idKecamatan) { this.idKecamatan = idKecamatan; }

    public String getNama_wisata() {
        return nama_wisata;
    }

    public void setNama_wisata(String nama_wisata) {
        this.nama_wisata = nama_wisata;
    }

    public String getAlamat() {
        return alamat;
    }

    public void setAlamat(String alamat) {
        this.alamat = alamat;
    }

    public String getcp() {
        return cp;
    }

    public void setcp(String cp) {
        this.cp = cp;
    }

    public String getDeskripsi() {return deskripsi; }

    public void setDeskripsi(String deskripsi) { this.deskripsi = deskripsi;}

    public String getGambar() {
        return gambar;
    }

    public void setGambar(String gambar) {
        this.gambar = gambar;
    }

    public String getAction() {
        return action;
    }

    public void setAction(String action) {
        this.action = action;
    }
}

