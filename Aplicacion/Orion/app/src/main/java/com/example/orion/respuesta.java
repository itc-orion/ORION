package com.example.orion;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

import java.util.List;

public class respuesta {

    @Expose
    public boolean ok;
    @Expose
    @SerializedName("objects")
    private List<objects> obj;
    @Expose
    private int count = 0;

    public respuesta(){}

    public respuesta(boolean ok, List<objects> obj, int count) {
        this.ok = ok;
        this.obj = obj;
        this.count = count;
    }

    public boolean isOk() {
        return ok;
    }

    public void setOk(boolean ok) {
        this.ok = ok;
    }

    public List<objects> getObj() {
        return obj;
    }

    public void setObj(List<objects> obj) {
        this.obj = obj;
    }

    public int getCount() {
        return count;
    }

    public void setCount(int count) {
        this.count = count;
    }

    public static objects parseJSON(String response){
        Gson gson = new GsonBuilder().create();
        objects obs = gson.fromJson(response, objects.class);
        return obs;
    }
}
