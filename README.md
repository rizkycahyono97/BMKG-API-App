# Weather Application with BMKG API Integration

## 📋 **Overview**  
A web application that provides real-time weather data for cities in Indonesia by integrating with the BMKG (Badan Meteorologi, Klimatologi, dan Geofisika) API. Users can log in, select their city, and retrieve accurate weather information.

---

## 🚀 **Features**  
- **City Selection:** Choose a city from a predefined list, populated dynamically from a database.  
- **BMKG API Integration:** Fetch weather data for the selected city using BMKG's API.  
- **Real-Time Updates:** Display the most recent weather conditions based on the selected city.  

---

## 🛠️ **Workflow**
1. **City Selection**  
   - Users select a city based on its **api_id**, which corresponds to the BMKG API's unique identifier for each city.

2. **API Request**  
   - The application constructs a request URL to the BMKG API using the selected city's `api_id`.
   - Example Endpoint:  
     ```
     https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={kode_wilayah_tingkat_iv}
     ```
   - The response is parsed and displayed on the user interface.

---

## 🔗 **API Details**

- **Base URL:** `https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4={kode_wilayah_tingkat_iv}`
- **Region Id:** `https://kodewilayah.id/`  
- **Parameters:**
  - `kode_wilayah_tingkat_iv`: Unique identifier for the selected city.
  - Example: `https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=35.02.01.2001`  

- ** Parameter:**  
  Example:
  ```
  utc_datetime: Waktu dalam UTC-YYYY-MM-DD HH:mm:ss
  local_datetime: Waktu lokal-YYYY-MM-DD HH:mm:ss
  t: Suhu Udara dalam °C
  hu: Kelembapan Udara dalam %
  weather_desc: Kondisi Cuaca dalam Indonesia
  weather_desc_en: Kondisi Cuaca dalam English
  ws: Kecepatan Angin dalam km/jam
  wd: Arah Angin dari
  tcc: Tutupan Awan dalam %
  vs_text: Jarak Pandang dalam km
  analysis_date: Waktu produksi data prakiraan cuaca dalam UTC-YYYY-MM-DDTHH:mm:ss
  ```

---

## 🔧 **Setup Guide**

### 1️⃣ **Prerequisites**
- PHP 8.3+
- Composer
- MySQL
- BMKG API Key

### 2️⃣ **Installation**
1. Clone the repository:
   ```bash
   git clone https://github.com/rizkycahyono97/weather-app.git
   cd weather-app
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Start the application:
   ```bash
   php -S localhost:4444
   ```

6. Access the application at:
   ```
   http://localhost:4444
   ```

---

## 🌎 **Usage Guide**

1. Select a city from the dropdown menu.
2. View the weather data fetched from the BMKG API.

---

## 🔍 **Sample Request**

### Request:
```http
GET https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=35.02.01.2001
```

### Response:
```json
{
"datetime": "2025-01-08T00:00:00Z",
"t": 25,
"tcc": 100,
"tp": 0,
"weather": 3,
"weather_desc": "Berawan",
"weather_desc_en": "Mostly Cloudy",
"wd_deg": 36,
"wd": "N",
"wd_to": "S",
"ws": 8.3,
"hu": 96,
"vs": 8871,
"vs_text": "< 9 km",
"time_index": "-3-0",
"analysis_date": "2025-01-08T00:00:00",
"image": "https://api-apps.bmkg.go.id/storage/icon/cuaca/berawan-am.svg",
"utc_datetime": "2025-01-08 00:00:00",
"local_datetime": "2025-01-08 07:00:00"
}
```

---

## 📌 **License**
This project is licensed under the [MIT License](LICENSE).

---

## 📧 **Contact**
For inquiries or support, contact us at [rizkycahyonoputra2004@gmail.com](mailto:rizkycahyonoputra2004@gmail.com).
