package Model;

import com.google.gson.annotations.SerializedName;

public class Biro {
    @SerializedName("id_biro")
    private int id_biro;
    @SerializedName("id_kecamatan")
    private int id_kecamatan;
    @SerializedName("nama_biro")
    private String nama_biro;
    @SerializedName("alamat")
    private String alamat;
    @SerializedName("cp")
    private String cp;
    @SerializedName("wisata")
    private int wisata;


    public Biro(int id_biro, int id_kecamatan, String nama_biro, String alamat, String cp, int wisata) {
        this.id_biro = id_biro;
        this.id_kecamatan = id_kecamatan;
        this.nama_biro = nama_biro;
        this.alamat = alamat;
        this.cp = cp;
        this.wisata = wisata;
    }

    public int getId_biro() {
        return id_biro;
    }
    public void setId_biro(int id_biro) {
        this.id_biro = id_biro;
    }

    public int getId_kecamatan() {
        return id_kecamatan;
    }
    public void setId_kecamatan(int id_kecamatan) {
        this.id_kecamatan = id_kecamatan;
    }

    public String getNama_biro() {
        return nama_biro;
    }
    public void setNama_biro(String nama_biro) { this.nama_biro = nama_biro; }

    public String getAlamat(){ return alamat; }
    public void setAlamat(String alamat){ this.alamat = alamat; }

    public String getCp(){ return cp; }
    public void setCp(String cp){ this.cp = cp; }

    public int getWisata(){ return wisata; }
    public void setWisata(int wisata){ this.wisata = wisata; }

}
