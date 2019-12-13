package com.example.orion;

import android.location.Location;
import android.location.LocationListener;
import android.location.LocationProvider;
import android.os.Bundle;
import android.util.Log;

public class Localizacion implements LocationListener {

    private MainActivity mainActivity;

    private boolean b = true;

    private double longitudeGPS, latitudeGPS;

    public Thread iniciaThread() {
        Thread t = new Thread(new Runnable() {
            @Override
            public void run() {
                while (true) {
                    b = true;
                    try {
                        Thread.sleep(2000);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }
            }
        });
        t.setDaemon(true);
        t.start();
        return t;
    }

    public void setMainActivity(MainActivity mainActivity) {
        this.mainActivity = mainActivity;
    }

    @Override
    public void onLocationChanged(Location loc) {
        if (b) {
            latitudeGPS = loc.getLatitude();
            longitudeGPS = loc.getLongitude();
            final String sLatitud = String.valueOf(latitudeGPS);
            final String sLongitud = String.valueOf(longitudeGPS);
            b = false;

            mainActivity.webSocket.send(  sLongitud + "," + sLatitud );
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
