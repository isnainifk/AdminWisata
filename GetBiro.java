package Model;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class GetBiro {

    @SerializedName("status")
    String status;
    @SerializedName("result")
    List<Biro> listDataBiro;
    @SerializedName("message")
    String message;

    public void setStatus(String status) {
        this.status = status;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public List<Biro> getListDataBiro() {
        return listDataBiro;
    }

    public void setListDataBiro(List<Biro> listDataBiro) {
        this.listDataBiro = listDataBiro;
    }

}
