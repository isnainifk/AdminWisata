package com.example.windows10.retrofit.Rest;

import com.example.windows10.retrofit.Model.GetWisata;
import com.example.windows10.retrofit.Model.GetPembelian;
import com.example.windows10.retrofit.Model.PostPutDelPembelian;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.HTTP;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Part;

public interface ApiInterface {
    @GET("pembelian/user")
    Call<GetPembelian> getPembelian();

    @FormUrlEncoded
    @POST("pembelian/user")
    Call<PostPutDelPembelian> postPembelian
            (@Field("id_pembelian") String idPembelian, @Field("id_pembeli") String idPembeli,
             @Field("tanggal_beli") String tanggalBeli, @Field("total_harga") String totalHarga,
             @Field("id_tiket") String idTiket);

    @FormUrlEncoded
    @PUT("pembelian/user")
    Call<PostPutDelPembelian> putPembelian(
            @Field("id_pembelian") String idPembelian, @Field("id_pembeli") String idPembeli,
            @Field("tanggal_beli") String tanggalBeli, @Field("total_harga") String totalHarga,
            @Field("id_tiket") String idTiket);

    @FormUrlEncoded
    @HTTP(method = "DELETE", path = "pembelian/user", hasBody = true)
    Call<PostPutDelPembelian> deletePembelian(@Field("id_pembelian") String idPembelian);

//    /********* PEMBELI *********/
    @GET("pembeli/all")
    Call<GetWisata> getPembeli();

    @Multipart
    @POST("pembeli/all")
    Call<GetWisata> postPembeli(
            @Part MultipartBody.Part file,
            @Part("nama") RequestBody nama,
            @Part("alamat") RequestBody alamat,
            @Part("telp") RequestBody telpn,
            @Part("action") RequestBody action
    );

    @Multipart
    @POST("pembeli/all")
    Call<GetWisata> putPembeli(
            @Part MultipartBody.Part file,
            @Part("id_pembeli") RequestBody idPembeli,
            @Part("nama") RequestBody nama,
            @Part("alamat") RequestBody alamat,
            @Part("telp") RequestBody telpn,
            @Part("action") RequestBody action
    );

    @Multipart
    @POST("pembeli/all")
    Call<GetWisata> deletePembeli(
            @Part("id_pembeli") RequestBody idPembeli,
            @Part("action") RequestBody action);

}

    //    /********* WISATA *********/
    @GET("wisata/all")
    Call<GetWisata> getWisata();

    @Multipart
    @POST("wisata/all")
    Call<GetWisata> postWisata(
            @Part MultipartBody.Part file,
            @Part("id_kecamatan") RequestBody id_kecamatan,
            @Part("nama_wisata") RequestBody nama_wisata,
            @Part("alamat") RequestBody alamat,
            @Part("cp") RequestBody cp,
            @Part("deskripsi") RequestBody deskripsi,
            @Part("action") RequestBody action
    );

    @Multipart
    @POST("wisata/all")
    Call<GetWisata> putPembeli(
            @Part MultipartBody.Part file,
            @Part("id_wisata") RequestBody idWisata,
            @Part("id_kecamatan") RequestBody id_kecamatan,
            @Part("nama_wisata") RequestBody nama_wisata,
            @Part("alamat") RequestBody alamat,
            @Part("cp") RequestBody cp,
            @Part("deskripsi") RequestBody deskripsi,
            @Part("action") RequestBody action
    );

    @Multipart
    @POST("wisata/all")
    Call<GetWisata> deleteWisata(
            @Part("id_wisata") RequestBody idWisata,
            @Part("action") RequestBody action);

}

