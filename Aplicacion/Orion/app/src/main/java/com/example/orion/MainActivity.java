package com.example.orion;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.location.LocationProvider;
import android.os.StrictMode;
import android.provider.Settings;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.BreakIterator;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class MainActivity extends AppCompatActivity implements Runnable {

    double longitudeGPS, latitudeGPS;
    TextView color,sc;
    int cont;

    String devuelve = "";
    String pagina = "";

    boolean tf = false;
    boolean b = true;

    int pos;

    private final DateFormat df = new SimpleDateFormat("HH:mm:ss:ms");

    private final List<semaforo> listS = new ArrayList<semaforo>();

    private Thread thread;

    private Animation animacion;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        color = (TextView) findViewById(R.id.txt);
        sc = (TextView) findViewById(R.id.sc);
        animacion = AnimationUtils.loadAnimation(this, R.anim.animacion);
        llenaLista();

        Thread t = new Thread(new Runnable() {
            @Override
            public void run() {
                while (true) {
                    b = true;
                    try {
                        Thread.sleep(10000);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }
            }
        });
        t.start();

        color.setBackgroundResource(R.color.black);

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION,}, 1000);
        } else {
            locationStart();
        }
    }

    private void locationStart() {
        LocationManager mlocManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        Localizacion Local = new Localizacion();
        Local.setMainActivity(this);
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

    public void onRequestPermissionsResult(int requestCode, String[] permissions, int[] grantResults) {
        if (requestCode == 1000) {
            if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                locationStart();
                return;
            }
        }
    }

    private void llenaLista() {
        listS.add(new semaforo("semaforo1", 47, 31, 15, 81));
        listS.add(new semaforo("semaforo3", 62, 35, 36, 100));
        listS.add(new semaforo("semaforo2", 57, 40, 42, 100));

    }

    public void iniciaTodo(int pos) {
        this.pos = pos;

        thread = new Thread(MainActivity.this);
        thread.start();
    }

    private void iniciaAnimacion(int pos) throws InterruptedException {

        String date = df.format(Calendar.getInstance().getTime());

        String arr[] = date.split(":");

        int h = Integer.parseInt(arr[0]) - 8;
        h *= 3600;
        int m = Integer.parseInt(arr[1]) * 60;
        int s = Integer.parseInt(arr[2]);

        int ts = h + m + s;
        int tt = listS.get(pos).getTotal();
        ts -= (tt - listS.get(pos).getSegS());

        int d = ts / tt;
        d *= tt;

        ts -= d;


        int tf = listS.get(pos).getTotal() - ts;

        if (ts <= listS.get(pos).getTg() && ts > 0) {
            tf -= (listS.get(pos).getTr() + 3);
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
            animacion.setDuration(listS.get(pos).getTr() * 1000);
            color.startAnimation(animacion);
            Thread.sleep(listS.get(pos).getTr() * 1000);
        } else if (ts <= (listS.get(pos).getTg() + 3) && ts > 0) {
            tf -= (listS.get(pos).getTr());
            //Toast.makeText(this, "Amarillo="+ts, Toast.LENGTH_LONG).show();
            color.setBackgroundResource(R.color.yellow);
            animacion.setDuration(tf * 1000);
            color.startAnimation(animacion);
            Thread.sleep(tf * 1000);
            color.setBackgroundResource(R.color.red);
            animacion.setDuration(listS.get(pos).getTr() * 1000);
            color.startAnimation(animacion);
            Thread.sleep(listS.get(pos).getTr() * 1000);
        } else if (ts <= (listS.get(pos).getTotal()) && ts > 0) {
            //Toast.makeText(this, "Rojo="+ts, Toast.LENGTH_LONG).show();
            color.setBackgroundResource(R.color.red);
            animacion.setDuration(tf * 1000);
            color.startAnimation(animacion);
            Thread.sleep(tf * 1000);
        }

        //Toast.makeText(this, "Comienza semafoto", Toast.LENGTH_SHORT).show();

    }

    @Override
    public void run() {
        long tg = listS.get(pos).getTg() * 1000, tr = listS.get(pos).getTr() * 1000;

        try {
            iniciaAnimacion(pos);
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

    public void muestraToast() {
        Toast.makeText(MainActivity.this, "Realiza peticion", Toast.LENGTH_SHORT).show();
    }

    /* Aqui empieza la Clase Localizacion */
    public class Localizacion implements LocationListener {
        MainActivity mainActivity;

        public MainActivity getMainActivity() {
            return mainActivity;
        }

        public void setMainActivity(MainActivity mainActivity) {
            this.mainActivity = mainActivity;
        }

        @Override
        public void onLocationChanged(Location loc) {


            if (b) {
                // cuandio hay cambios en el GPS
                loc.getLatitude();
                loc.getLongitude();
                final String sLatitud = String.valueOf(loc.getLatitude());
                final String sLongitud = String.valueOf(loc.getLongitude());
                b = false;

                StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
                StrictMode.setThreadPolicy(policy);

                respuesta res = new respuesta();

                try {

                    URL url = new URL("https://65e598bd.ngrok.io/nearby+fleet+point+" + sLatitud + "+" + sLongitud + "+50");
                    HttpURLConnection conexion = (HttpURLConnection) url.openConnection();


                    if (conexion.getResponseCode() == HttpURLConnection.HTTP_OK) {
                        BufferedReader reader = new BufferedReader(new
                                InputStreamReader(conexion.getInputStream()));
                        String linea = reader.readLine();
                        while (linea != null) {
                            pagina += linea;
                            linea = reader.readLine();
                        }
                        reader.close();
                    } else {
                        devuelve = "ERROR: " + conexion.getResponseMessage();
                    }
                    conexion.disconnect();

                    Gson gson = new GsonBuilder().create();
                    res = gson.fromJson(pagina, respuesta.class);

                    /*String arr[] = pagina.split(",");

                    if (arr.length > 5){
                        String arr2[] = arr[1].split(":");
                        res.setCount(1);
                        res.setObj(new ArrayList<objects>());
                        String r = arr2[2].substring(1,(arr2[2].length()-1));
                        res.getObj().add(new objects(r));
                        String s = res.getObj().get(0).getId();
                    }*/

                    pagina = "";

                    if (res.getCount() != 0) {
                        if (!tf) {
                            sc.setVisibility(View.INVISIBLE);
                            color.setVisibility(View.VISIBLE);
                            int pos = 10;
                            for (int i = 0; i < listS.size(); i++) {
                                if (listS.equals(res.getObj().get(0).getId())) {
                                    pos = i;
                                    break;
                                }
                            }
                            if (pos == 10) {
                                iniciaTodo(0);
                            } else {
                                iniciaTodo(pos);
                            }
                            tf = true;
                        }
                    } else {
                        if (tf) {
                            thread.interrupt();
                            sc.setVisibility(View.VISIBLE);
                            color.setVisibility(View.INVISIBLE);
                            tf = false;
                        }
                    }

                } catch (Exception e) {
                    Log.e("Error", "Exception: " + e.getMessage());
                }

            }

        }

        @Override
        public void onProviderDisabled(String provider) {
            // Este metodo se ejecuta cuando el GPS es desactivado

        }

        @Override
        public void onProviderEnabled(String provider) {
            // Este metodo se ejecuta cuando el GPS es activado

        }

        @Override
        public void onStatusChanged(String provider, int status, Bundle extras) {
            switch (status) {
                case LocationProvider.AVAILABLE:
                    Log.d("debug", "LocationProvider.AVAILABLE");
                    break;
                case LocationProvider.OUT_OF_SERVICE:
                    Log.d("debug", "LocationProvider.OUT_OF_SERVICE");
                    break;
                case LocationProvider.TEMPORARILY_UNAVAILABLE:
                    Log.d("debug", "LocationProvider.TEMPORARILY_UNAVAILABLE");
                    break;
            }
        }
    }


}
