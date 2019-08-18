package com.example.orion;

import com.google.gson.annotations.Expose;

public class objects {

    @Expose
    String id;

    public objects() {
    }

    public objects(String id) {
        this.id = id;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }
}
