package com.example.windows10.retrofit.Model;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;
import java.util.List;

public class GetWisata {
    @SerializedName("status")
    private String status;
    @SerializedName("result")
    private List<Wisata> result = new ArrayList<Wisata>();
    @SerializedName("message")
    private String message;
    public GetWisata() {}

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public List<Wisata> getResult() {
        return result;
    }

    public void setResult(List<Wisata> result) {
        this.result = result;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}

