package Rest;


import Model.GetBiro;
import Model.PostPutDelBiro;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.HTTP;
import retrofit2.http.POST;
import retrofit2.http.PUT;

public interface ApiInterface {
    @GET("rest_travel/biro")
    Call<GetBiro> getBiro();

    @FormUrlEncoded
    @POST("rest_travel/biro")
    Call<PostPutDelBiro> postBiro
            (@Field("id_biro") String idBiro, @Field("id_kecamatan") String idKecamatan,
             @Field("nama_biro") String namaBiro, @Field("alamat") String alamat,
             @Field("cp") String cp, @Field("wisata") String wisata);

    @FormUrlEncoded
    @PUT("rest_travel/biro")
    Call<PostPutDelBiro> putBiro
            (@Field("id_biro") String idBiro, @Field("id_kecamatan") String idKecamatan,
             @Field("nama_biro") String namaBiro, @Field("alamat") String alamat,
             @Field("cp") String cp, @Field("wisata") String wisata);

    @FormUrlEncoded
    @HTTP(method = "DELETE", path = "rest_travel/biro", hasBody = true)
    Call<PostPutDelBiro> deleteBiro(@Field("id_biro") String idBiro);

}
