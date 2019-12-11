package com.example.orion;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.location.LocationProvider;
import android.provider.Settings;
import android.support.annotation.Nullable;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;


import com.example.orion.jsonSemaforo.semaforo;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import okhttp3.WebSocket;
import okhttp3.WebSocketListener;
import okio.ByteString;


public class MainActivity extends AppCompatActivity implements Runnable {

    protected TextView color, sc;
    int cont, id = 4;

    private semaforo se;

    protected boolean tf = false;

    private String url;

    int pos;

    private final DateFormat df = new SimpleDateFormat("HH:mm:ss:ms");

    protected Thread thread;

    private Animation animacion;

    protected WebSocket webSocket;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        color = (TextView) findViewById(R.id.txt);
        sc = (TextView) findViewById(R.id.sc);
        animacion = AnimationUtils.loadAnimation(this, R.anim.animacion);

        color.setBackgroundResource(R.color.black);


    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()){
            case R.id.url:
                mostrarCuadroDeDialogo();
                return true;
            default:
            return super.onOptionsItemSelected(item);
        }
    }

    private void mostrarCuadroDeDialogo() {
        AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
        LayoutInflater inflater = getLayoutInflater();

        View view = inflater.inflate(R.layout.dialog, null);
        builder.setView(view);

        final AlertDialog dialog = builder.create();

        dialog.show();

        final EditText urlET = (EditText) view.findViewById(R.id.url);

        Button aceptar = (Button) view.findViewById(R.id.Aceptar);
        aceptar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                url = urlET.getText().toString();

                if (!url.isEmpty()) {
                    instantiateWebSocket();
                    iniciaLocalizacion();
                    dialog.dismiss();
                } else {
                    Toast.makeText(MainActivity.this, "Ingresa un valor valido", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    private void iniciaLocalizacion() {
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION,}, 1000);
        } else {
            locationStart();
        }
    }

    private void instantiateWebSocket() {
        OkHttpClient client = new OkHttpClient();

        Request request = new Request.Builder().url(url).build();

        SocketListener socketListener = new SocketListener(this);

        webSocket = client.newWebSocket(request, socketListener);
    }

    private void locationStart() {
        LocationManager mlocManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        Localizacion Local = new Localizacion();
        Local.setMainActivity(this);
        Local.iniciaThread();
        final boolean gpsEnabled = mlocManager.isProviderEnabled(LocationManager.GPS_PROVIDER);
        if (!gpsEnabled) {
            Intent settingsIntent = new Intent(Settings.ACTION_LOCATION_SOURCE_SETTINGS);
            startActivity(settingsIntent);
        }
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION,}, 1000);
            return;
        }
        mlocManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0, 0, (LocationListener) Local);
        mlocManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, (LocationListener) Local);

    }

    public void onRequestPermissionsResult(int requestCode, String[] permissions,
                                           int[] grantResults) {
        if (requestCode == 1000) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                locationStart();
                return;
            }
        }
    }

    public void iniciaTodo(semaforo se) {
        this.se = se;

        thread = new Thread(MainActivity.this);
        thread.start();
    }

    private void iniciaAnimacion() throws InterruptedException {

        String date = df.format(se.getFin_suspencion());

        String arr[] = date.split(":");

        int h = Integer.parseInt(arr[0]) - 8;
        h *= 3600;
        int m = Integer.parseInt(arr[1]) * 60;
        int s = Integer.parseInt(arr[2]);

        int ts = h + m + s;
        int tt = se.getTotal();
        ts -= (tt - se.getTiempo_inicio());

        int d = ts / tt;

        d *= tt;

        ts -= d;


        int tf = se.getTotal() - ts;

        if (ts <= se.getTiempo_verde() && ts > 0) {
            tf -= (se.getTiempo_verde() + 3);
            //Toast.makeText(this, "verde="+ts, Toast.LENGTH_LONG).show();
            color.setBackgroundResource(R.color.green);
            animacion.setDuration(tf * 1000);
            color.startAnimation(animacion);
            Thread.sleep(tf * 1000);
            color.setBackgroundResource(R.color.yellow);
            animacion.setDuration(3000);
            color.startAnimation(animacion);
            Thread.sleep(3000);
            color.setBackgroundResource(R.color.red);
            animacion.setDuration(se.getTiempo_rojo() * 1000);
            color.startAnimation(animacion);
            Thread.sleep(se.getTiempo_rojo() * 1000);
        } else if (ts <= (se.getTiempo_verde() + 3) && ts > 0) {
            tf -= (se.getTiempo_verde());
            //Toast.makeText(this, "Amarillo="+ts, Toast.LENGTH_LONG).show();
            color.setBackgroundResource(R.color.yellow);
            animacion.setDuration(tf * 1000);
            color.startAnimation(animacion);
            Thread.sleep(tf * 1000);
            color.setBackgroundResource(R.color.red);
            animacion.setDuration(se.getTiempo_rojo() * 1000);
            color.startAnimation(animacion);
            Thread.sleep(se.getTiempo_rojo() * 1000);
        } else if (ts <= (se.getTotal()) && ts > 0) {
            //Toast.makeText(this, "Rojo="+ts, Toast.LENGTH_LONG).show();
            color.setBackgroundResource(R.color.red);
            animacion.setDuration(tf * 1000);
            color.startAnimation(animacion);
            Thread.sleep(tf * 1000);
        }

    }

    @Override
    public void run() {
        long tg = se.getTiempo_verde() * 1000, tr = se.getTiempo_rojo() * 1000;

        try {
            iniciaAnimacion();
            while (true) {
                color.setBackgroundResource(R.color.green);
                animacion.setDuration(tg);
                color.startAnimation(animacion);
                Thread.sleep(tg);
                color.setBackgroundResource(R.color.yellow);
                animacion.setDuration(3000);
                color.startAnimation(animacion);
                Thread.sleep(3000);
                color.setBackgroundResource(R.color.red);
                animacion.setDuration(tr);
                color.startAnimation(animacion);
                Thread.sleep(tr);
            }
        } catch (InterruptedException e) {
            System.out.println("stop");
        }
    }

}
