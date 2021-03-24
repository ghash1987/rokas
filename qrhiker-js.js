function resizeIframe(obj) {
  obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
}


function getCurrentLocation() {
  navigator.geolocation.getCurrentPosition(
    geoCurrentRedirect,
    errorCallback_highAccuracy,
    { maximumAge: 10, timeout: 270000, enableHighAccuracy: true }
    );
  }
  
  function geoCurrentRedirect(position) {
    // x.innerHTML = "Latitude: " + position.coords.latitude +
    //"<br>Longitude: " + position.coords.longitude;
    var geo_lat = position.coords.latitude;
    var geo_long = position.coords.longitude;
    
    document.getElementById("geo_lat").value = geo_lat;
    document.getElementById("geo_long").value = geo_long;
    document.getElementById("geo_acc").value = position.coords.accuracy;
  }
  
  function errorCallback_highAccuracy(error) {
    var hibakod = "nincs-hiba-high";
    switch (error.code) {
      case 0:
      hibakod = "unknown error";
      break;
      case 1:
      hibakod = "permission denied";
      break;
      case 2:
      hibakod = "position unavailable";
      break;
      case 3:
      hibakod = "timed out";
      break;
    }
    hibakod += "-high";
    document.getElementById("hiba").value = hibakod;
    if (navigator.geolocation) {
      // navigator.geolocation.getCurrentPosition(geoCurrentRedirect, errorCallback_lowAccuracy, {maximumAge:0, timeout: 5000, enableHighAccuracy: false});
    } else {
      document.getElementById("szoveg").value =
      "A böngésződ nem támogatja a helymeghatározást";
      document.getElementById("hiba").value =
      "A böngésződ nem támogatja a helymeghatározást2";
    }
  }
  
  function handlePermission() {
    if ("geolocation" in navigator) {
      getCurrentLocation();
    } else {
      document.getElementById("szoveg").value =
      "A böngésződ nem támogatja a helymeghatározást";
      document.getElementById("hiba").value =
      "A böngésződ nem támogatja a helymeghatározást";
      getCurrentLocation();
    }
  }
  
  function user() {
    "use strict";
    
    var module = {
      options: [],
      header: [
        navigator.platform,
        navigator.userAgent,
        navigator.appVersion,
        navigator.vendor,
        window.opera,
      ],
      dataos: [
        { name: "Windows Phone", value: "Windows Phone", version: "OS" },
        { name: "Windows", value: "Win", version: "NT" },
        { name: "iPhone", value: "iPhone", version: "OS" },
        { name: "iPad", value: "iPad", version: "OS" },
        { name: "Kindle", value: "Silk", version: "Silk" },
        { name: "Android", value: "Android", version: "Android" },
        { name: "PlayBook", value: "PlayBook", version: "OS" },
        { name: "BlackBerry", value: "BlackBerry", version: "/" },
        { name: "Macintosh", value: "Mac", version: "OS X" },
        { name: "Linux", value: "Linux", version: "rv" },
        { name: "Palm", value: "Palm", version: "PalmOS" },
      ],
      databrowser: [
        { name: "Chrome", value: "Chrome", version: "Chrome" },
        { name: "Firefox", value: "Firefox", version: "Firefox" },
        { name: "Safari", value: "Safari", version: "Version" },
        { name: "Internet Explorer", value: "MSIE", version: "MSIE" },
        { name: "Opera", value: "Opera", version: "Opera" },
        { name: "BlackBerry", value: "CLDC", version: "CLDC" },
        { name: "Mozilla", value: "Mozilla", version: "Mozilla" },
      ],
      init: function () {
        var agent = this.header.join(" "),
        os = this.matchItem(agent, this.dataos),
        browser = this.matchItem(agent, this.databrowser);
        
        return { os: os, browser: browser };
      },
      matchItem: function (string, data) {
        var i = 0,
        j = 0,
        html = "",
        regex,
        regexv,
        match,
        matches,
        version;
        
        for (i = 0; i < data.length; i += 1) {
          regex = new RegExp(data[i].value, "i");
          match = regex.test(string);
          if (match) {
            regexv = new RegExp(data[i].version + "[- /:;]([\\d._]+)", "i");
            matches = string.match(regexv);
            version = "";
            if (matches) {
              if (matches[1]) {
                matches = matches[1];
              }
            }
            if (matches) {
              matches = matches.split(/[._]+/);
              for (j = 0; j < matches.length; j += 1) {
                if (j === 0) {
                  version += matches[j] + ".";
                } else {
                  version += matches[j];
                }
              }
            } else {
              version = "0";
            }
            return {
              name: data[i].name,
              version: parseFloat(version),
            };
          }
        }
        return { name: "unknown", version: 0 };
      },
    };
    
    var e = module.init(),
    debug = "";
    var osname = e.os.name;
    debug += "os.name = " + e.os.name + "<br/>";
    debug += "os.version = " + e.os.version + "<br/>";
    debug += "browser.name = " + e.browser.name + "<br/>";
    debug += "browser.version = " + e.browser.version + "<br/>";
    
    document.getElementById("osnamer").value = e.os.name;
    document.getElementById("os_version").value = e.os.version;
    document.getElementById("browser_name").value = e.browser.name;
    document.getElementById("browser_version").value = e.browser.version;
  }
  
  function get_distance(lat1, lon1, lat2, lon2) {
    unit = "K";
    if (lat1 == lat2 && lon1 == lon2) {
      return 0;
    } else {
      var radlat1 = (Math.PI * lat1) / 180;
      var radlat2 = (Math.PI * lat2) / 180;
      var theta = lon1 - lon2;
      var radtheta = (Math.PI * theta) / 180;
      var dist =
      Math.sin(radlat1) * Math.sin(radlat2) +
      Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
      if (dist > 1) {
        dist = 1;
      }
      dist = Math.acos(dist);
      dist = (dist * 180) / Math.PI;
      dist = dist * 60 * 1.1515;
      if (unit == "K") {
        dist = dist * 1.609344;
      }
      if (unit == "N") {
        dist = dist * 0.8684;
      }
      return dist;
    }
  }
  
  function sec2time(timeInSeconds) {
    var pad = function (num, size) {
      return ("000" + num).slice(size * -1);
    },
    time = parseFloat(timeInSeconds).toFixed(3),
    hours = Math.floor(time / 60 / 60),
    minutes = Math.floor(time / 60) % 60,
    seconds = Math.floor(time - minutes * 60),
    milliseconds = time.slice(-3);
    
    return pad(hours, 2) + ":" + pad(minutes, 2) + ":" + pad(seconds, 2);
  }
  