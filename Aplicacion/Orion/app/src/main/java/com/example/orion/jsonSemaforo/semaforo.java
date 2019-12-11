 package com.example.orion.jsonSemaforo;

public class semaforo {

    String fin_suspencion;

    int tiempo_verde;

    int tiempo_amarillo;

    int tiempo_rojo;

    int tiempo_inicio;

    public semaforo(String fin_suspencion, int tiempo_verde, int tiempo_amarillo, int tiempo_rojo, int tiempo_inicio) {
        this.fin_suspencion = fin_suspencion;
        this.tiempo_verde = tiempo_verde;
        this.tiempo_amarillo = tiempo_amarillo;
        this.tiempo_rojo = tiempo_rojo;
        this.tiempo_inicio = tiempo_inicio;
    }

    public semaforo() {
    }

    public String getFin_suspencion() {
        return fin_suspencion;
    }

    public void setFin_suspencion(String fin_suspencion) {
        this.fin_suspencion = fin_suspencion;
    }

    public int getTiempo_verde() {
        return tiempo_verde;
    }

    public void setTiempo_verde(int tiempo_verde) {
        this.tiempo_verde = tiempo_verde;
    }

    public int getTiempo_amarillo() {
        return tiempo_amarillo;
    }

    public void setTiempo_amarillo(int tiempo_amarillo) {
        this.tiempo_amarillo = tiempo_amarillo;
    }

    public int getTiempo_rojo() {
        return tiempo_rojo;
    }

    public void setTiempo_rojo(int tiempo_rojo) {
        this.tiempo_rojo = tiempo_rojo;
    }

    public int getTiempo_inicio() {
        return tiempo_inicio;
    }

    public void setTiempo_inicio(int tiempo_inicio) {
        this.tiempo_inicio = tiempo_inicio;
    }

    public int getTotal(){
        return tiempo_amarillo+tiempo_rojo+tiempo_verde;
    }
}
