package com.example.orion;

public class semaforo {

    private String name;
    private int tg,tr,segS,total;

    public semaforo(String name, int tg, int tr, int segS, int total) {
        this.name = name;
        this.tg = tg;
        this.tr = tr;
        this.segS = segS;
        this.total = total;
    }

    public String getName() {
        return name;
    }

    public int getTg() {
        return tg;
    }

    public int getTr() {
        return tr;
    }

    public int getSegS() {
        return segS;
    }

    public int getTotal() {
        return total;
    }
}
