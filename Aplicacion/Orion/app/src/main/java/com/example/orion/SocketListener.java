package com.example.orion;

import android.support.annotation.Nullable;
import android.view.View;
import android.widget.Toast;

import com.example.orion.jsonSemaforo.Json;
import com.example.orion.jsonSemaforo.semaforo;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import okhttp3.Response;
import okhttp3.WebSocket;
import okhttp3.WebSocketListener;
import okio.ByteString;

public class SocketListener extends WebSocketListener {


    public MainActivity activity;

    private boolean tf = false;

    int cont, id = 4;

    public SocketListener(MainActivity activity) {
        this.activity = activity;
    }


    @Override
    public void onOpen(WebSocket webSocket, Response response) {


        activity.runOnUiThread(new Runnable() {

            @Override
            public void run() {

                Toast.makeText(activity, "Coneccion establecida!", Toast.LENGTH_LONG).show();

            }

        });

    }

    @Override
    public void onMessage(final WebSocket webSocket, final String text) {

        activity.runOnUiThread(new Runnable() {
            @Override
            public void run() {
                if (!text.equals("false") && !tf) {
                    tf = true;
                    activity.sc.setVisibility(View.INVISIBLE);
                    activity.color.setVisibility(View.VISIBLE);

                    /*Gson gson = new GsonBuilder().create();
                    Json j = gson.fromJson(text, Json.class);

                    activity.iniciaTodo(j.getSemaforo().get(0));*/

                    activity.iniciaTodo(new semaforo("05:30:00", 38, 3, 19, 0));
                } else if (text.equals("false") && tf) {
                    activity.thread.interrupt();
                    activity.sc.setVisibility(View.VISIBLE);
                    activity.color.setVisibility(View.INVISIBLE);
                    tf = false;
                }
            }
        });


    }


    @Override
    public void onMessage(WebSocket webSocket, ByteString bytes) {
        super.onMessage(webSocket, bytes);
    }


    @Override
    public void onClosing(WebSocket webSocket, int code, String reason) {
        super.onClosing(webSocket, code, reason);
    }


    @Override
    public void onClosed(WebSocket webSocket, int code, String reason) {
        super.onClosed(webSocket, code, reason);
    }


    @Override
    public void onFailure(WebSocket webSocket, final Throwable t,
                          @Nullable final Response response) {
        super.onFailure(webSocket, t, response);
    }
}