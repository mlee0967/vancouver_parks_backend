#### Datasets

Dataset for table `parks` from: https://opendata.vancouver.ca/explore/dataset/parks/information/

Dataset for table `parks_facilities` from: https://opendata.vancouver.ca/explore/dataset/parks-facilities/information/

#### Endpoints

`[GET] /api/parks` : returns all park info

`[GET] /api/facility_types` : returns all facility types (e.g. washrooms, soccer fields)

`[POST] /api/park_ids` : returns ParkIDs that have certain facilities. e.g. request with `body: {"filters": ["Washrooms", "Soccer Fields"]}` will return all ParkIDs of parks with washrooms and soccer fields.
