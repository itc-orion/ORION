package com.example.orion.jsonSemaforo;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.util.List;

public class Json {

    private List<semaforo> Semaforos;

    public Json(List<semaforo> Semaforos) {
        this.Semaforos = Semaforos;
    }

    public Json() {
    }

    public List<semaforo> getSemaforo() {
        return Semaforos;
    }

    public void setSemaforo(List<semaforo> semaforo) {
        this.Semaforos = semaforo;
    }

    public static semaforo parseJSON(String response){
        Gson gson = new GsonBuilder().create();
        semaforo semaforos = gson.fromJson(response, semaforo.class);
        return semaforos;
    }

}
