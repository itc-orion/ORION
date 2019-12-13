package com.example.orion.jsonSemaforo;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.util.List;

public class Json {

    private List<semaforo> semaforo;

    public Json(List<semaforo> semaforo) {
        this.semaforo = semaforo;
    }

    public Json() {
    }

    public List<semaforo> getSemaforo() {
        return semaforo;
    }

    public void setSemaforo(List<semaforo> semaforo) {
        this.semaforo = semaforo;
    }

    public static semaforo parseJSON(String response){
        Gson gson = new GsonBuilder().create();
        semaforo semaforos = gson.fromJson(response, semaforo.class);
        return semaforos;
    }

}
