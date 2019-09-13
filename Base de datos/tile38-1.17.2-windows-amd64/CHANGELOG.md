# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [1.17.2] - 2019-06-28

### Fixes
- #422: Fixes NEARBY command distance normalization issue (@TrivikrAm-Pamarthi, @melbania)

## [1.17.1] - 2019-05-04

### Fixes
- #448: Fixed missing commands for unsubscribing from active channel (@githubfr)
- #454: Fixed colored output for fatalf (@olevole)
- #453: Fixed nearby json field results showing wrong data (@melbania)

## [1.17.0] - 2019-04-26
### Added
- #446: Added timeouts to allow prepending commands with a TIMEOUT option. (@rshura)

### Fixes
- #440: Fixed crash with fence ROAM (@githubfr)

### Changes
- 3ae5927: Removed experimental evio option

## [1.16.4] - 2019-03-19
### Fixes
- e1a7145: Hotfix. Do not ignore SIGHUP. Use the `--nohup` flag or `nohup` command.

## [1.16.3] - 2019-03-19
### Fixes
- #437: Fixed clients blocking while webook sending. (@tesujiro)

### Added
- #430: Support more SQS credential providers. (@tobilg)
- #435: Added pprof flags for optional memory and cpu diagnostics.
- e47540b: Added auth flag to tile38-benchmark.
- 5335aec: Allow for standard SQS URLs. (@tobilg)

## [1.16.2] - 2019-03-12
### Fixes
- #432: Ignore SIGHUP signals. (@abhit011)
- #433: Fixed nearby inaccuracy with geofence. (@stcktrce)
- #429: Memory optimization, recycle AOF buffer.
- 95a5556: Added periodic yielding to iterators. (@rshura)

## [1.16.1] - 2019-03-01
### Fixes
- #421: Nearby with MATCH is returning invalid results (@nithinkota)

## [1.16.0] - 2019-02-25
### Fixes
- #415: Fixed overlapping geofences sending notifcation to wrong endpoint. (@belek, @s32x)
- #412: Allow SERVER command for Lua scripts. (@1995parham)
- #410: Allow slashes in MQTT Topics (@pstuifzand)
- #409: Fixed bug in polygon clipping. (@rshura)
- 30f903b: Require properties member for geojson features. (@rshura)

### Added
- #409: Added TEST command for executing WITHIN and INTERSECTS on two objects. (@rshura)
- #407: Allow 201 & 202 status code on webhooks. (@s32x)
- #404: Adding more replication data to INFO response. (@s32x)

## [1.15.0] - 2019-01-16
### Fixes
- #403: JSON Output for INFO and CLIENT (@s32x)
- #401: Fixing KEYS command (@s32x)
- #398: Ensuring channel publish order (@s32x)
- d7d0baa: Fix roam fence missing

### Added
- #402: Adding ARM and ARM64 packages (@s32x)
- #399: Add RequireValid and update geojson dependency (@stevelacy)
- #396: Add distance_to function to the tile38 namespace in lua. (@rshura)
- #395: Add RENAME and RENAMENX commands. (@rshura)

## [1.14.4] - 2018-12-03
### Fixes
- #394: Hotfix MultiPolygon intersect failure. (@contra)
- #392: Fix TLS certs missing in Docker. (@vziukas, @s32x)

### Added
- Add extended server stats with SERVER EXT. (@s32x)
- Add Kafka key to match notication key. (@Joey92)
- Add optimized spatial index for fences

## [1.14.3] - 2018-11-20
### Fixes
- Hotfix SCRIPT LOAD not executing from cli. (@rshura)

## [1.14.2] - 2018-11-15
### Fixes
- #386: Fix version not being set at build. (@stevelacy)

## [1.14.1] - 2018-11-15
### Fixes
- #385: Add `version` to SERVER command response (@stevelacy)
- Hotfix replica sync needs flushing (@rshura)
- Fixed a bug where some AOF commands where corrupted during reload

## [1.14.0] - 2018-11-11
### Added
- INTERSECT/WITHIN optimization that may drastically improve searching polygons that have lots of points.
- Faster responses for write operations such as SET/DEL
- NEARBY now always returns objects from nearest to farthest (@rshura)
- kNN haversine distance optimization (@rshura)
- Evio networking beta using the "-evio yes" and "-threads num" flags

### Fixes
- #369: Fix poly in hole query

## [1.13.0] - 2018-08-29
### Added
- eef5f3c: Add geofence notifications over pub/sub channels
- 3a6f366: Add NODWELL keyword to roaming geofences
- #343: Add Nats endpoints (@lennycampino)
- #340: Add MQTT tls/cert options (@tobilg)
- #314: Add CLIP subcommand to INTERSECTS (@rshura)

### Changes
- 3ae26e3: Updated B-tree implementation
- 1d78a41: Updated R-tree implementation

## [1.12.3] - 2018-06-16
### Fixed
- #316: Fix AMQP and AMQPS webhook endpoints to support namespaces (@DeadWisdom)
- #318: Fix aofshrink crash on windows (@abhit011)
- #326: Fix sporadic kNN results when TTL is used (@pmaseberg)

## [1.12.2] - 2018-05-10
### Fixed
- #313: Hotfix intersect returning incorrect results (@stevelacy)

## [1.12.1] - 2018-04-30
### Fixed
- #300: Fix pdelhooks not persisting (@tobilg)
- #293: Fix kafka lockup issue (@Joey92)
- #301: Fix AMQP uri custom params not working (@tobilg)
- #302: Fix tile with zoom level over 63 panics (@rshura)
- b99cd39: Fix Sync hook msg ttl with server time

## [1.12.0] - 2018-04-12
### Added
- 11b42c0: Option to disable AOF or to use a custom path: #220 #223 #297 (@sign0, @umpc, @fmr683, @zhangfeng158)
- #296: Add Meta data to hooks command (@tobilg)

### Changes
- 11b42c0: Updated help menu and show more options

### Fixed
- #295: Intersects returning nothing in some cases (@fils)
- #294: HTTP requests stopped working (@zhangfeng158)
- 0aa04a1: Lotsa package not vendored

## [1.11.1] - 2018-03-16
### Added
- #272: Preserve Docker image tag history (@gechr)
- 9428b84: Added cpu and threads to SERVER stats

### Fixed
- #281: Linestring intersection failure (@contra)
- #280: Filter id match before kNN results (@sweco-semtne)
- #269: Safe atomic ints for arm32 (@gmonk63)
- #267: Optimization for multiploygons intersect queries (@contra)

## [1.11.0] - 2018-03-05
### Added
- #221: Add WHEREEVAL clause to scan/search commands (@rshura)

### Fixed
- #254: Add maxmemory protection to FSET (@rshura)
- #258: Clear expires on reset (@zycbobby)
- #268: Avoid bbox intersect for non-bbox objects (@contra)

## [1.10.1] - 2018-01-17
### Fixed
- #244: Fix issue with points not being detected inside MultiPolygons (@fazlul3003)
- #245: Precalculate and store bboxes for complex objects (@huangpeizhi)
- #246: Fix server crash when receiving zero arg commands (@behrad)

## [1.10.0] - 2017-12-18
### Added
- #221: Sqs endpoint (@lennycampino)
- #226: Lua scripting (@rshura) 
- #231: Allow setting multiple fields in a single fset command (@rshura)
- #235: Add json library (encode/decode methods) to lua. (@rshura)
- 26d0083: Update vendoring to use golang/dep 
- c8ed7ca: Add WHEREIN command (@rshura)
- d817814: Optimized network pipelining

### Fixed
- #237: Flush to file periodically (@rshura)
- #241: Point match on interior hole (@genesor)
- 920dc3a: Use atomic ints/bools
- 730502d: Set keepalive default to 300 seconds
- 1084c60: Apply limit on top of cursor (@rshura)

## [1.9.1] - 2017-08-16
### Added
- cd05708: Spatial index optimizations
- #208: Debug message for failed webhook notifications (@karnivas)
- #201: New ECHO command (@yorkxiao)
- #183: Include tile38-cli in Docker image (@jchamberlain)
- #121: Allow reads for disconnected followers (@octete)

### Fixed
- 3fae3f7: Allow cursors for kNN queries
- #211: Crash when shrinking AOF on Windows (@icewukong)
- #203: Lifted LIMIT restriction all queries and COUNT keyword (@yorkxiao, @FX-HAO)
- #207: Send empty results for queries on nonexistent keys (@FX-HAO)
- #195: Added kNN overscan ordering (@rshura)
- #199: Apply LIMIT after WHERE clause (@rshura)
- #199: Require Go 1.7 (@rshura)
- #198: Omit fields for Resp when NOFIELDS is used (@rshura)

## [1.9.0] - 2017-04-13
### Added
- #159: AMQP/RabbitMQ webhook support (@m1ome, @paavalan)
- #152: Kafka webhook support (@m1ome)
- #141: Add distances to Geofence notifications
- #54: New benchmark tool (@literadix, @Lars-Meijer, @m1ome)
- #20: Ability to specify pidfile via args (@olevole)

### Fixed
- b1c76d7: tile38-cli auto doesn't auto reconnect
- #156: Use redis-style TTL implementation (@Lars-Meijer, @m1ome)
- #150: Live "inside" fence event not triggering for new object (@phulst)

## [1.8.0] - 2017-02-21
### Added
- #145: TCP Keepalives option (@UriHendler)
- #136: K nearest neighbors for NEARBY command (@m1ome, @tomquas, @joernroeder)
- #139: Added CLIENT command (@UriHendler)
- #133: AutoGC config option (@m1ome, @amorskoy)

### Fixed
- #147: Leaking http hook connections (@mkabischev)
- #143: Duplicate data in hook data (@mkabischev)

## [1.7.5] - 2017-01-13
### Added
- Performance bump for all SET commands, ~10% faster
- Lower memory footprint for large datasets
- #112: Added distance to NEARBY command (@m1ome, @auselen)
- #123: Redis endpoint for webhooks (@m1ome)
- #128: Allow disabling HTTP & WebSocket transport (@m1ome)

### Fixed
- #116: Missing response in TTL json command (@phulst)
- #117: Error in command documentation (@juanpabloaj)
- #118: Unexpected EOF bug with websockets (@m1ome)
- #122: Disque typo timeout handling (@m1ome)
- #127: 3d object searches with 2d geojson area (@damariei)

## [1.7.0] - 2016-12-29
### Added
- #104: PDEL command - Selete objects that match a pattern (@GameFreedom)
- #99: COMMAND keyword for masking geofences by command type (@amorskoy)
- #96: SCAN keyword for roaming geofences
- fba34a9: JSET, JGET, JDEL commands

### Fixed
- #107: Memory leak (@amorskoy)
- #98: Output json fix

## [1.6.0] - 2016-12-11
### Added
- #87: Fencing event grouping (@huangpeizhi)

### Fixed
- #91: Wrong winding order for CirclePolygon function (@antonioromano)
- #73: Corruption for AOFSHRINK (@huangpeizhi)
- #71: Lower memory usage. About 25% savings (@thisisaaronland, @umpc)
- Polygon raycast bug. tidwall/poly#1 (@drewlesueur)
- Added black-box testing

## [1.5.4] - 2016-11-17
### Fixed
- #84: Hotfix - roaming fence deadlock (@tomquas)

## [1.5.3] - 2016-11-16
### Added
- #4: Official docker support (@gordysc)

### Fixed
- #77: NX/XX bug (@damariei)
- #76: Match on prefix star (@GameFreedom, @icewukong)
- #82: Allow for precise search for strings (@GameFreedom)
- #83: Faster congruent modulo for points (@icewukong, @umpc)

## [1.5.2] - 2016-10-20
### Fixed
- #70: Invalid results for INTERSECTS query (@thisisaaronland)

## [1.5.1] - 2016-10-19
### Fixed
- #67: Call the EXPIRE command hangs the server (@PapaStifflera)
- #64: Missing points in 'Nearby' queries (@umpc)

## [1.5.0] - 2016-10-03
### Added
- #61: Optimized queries on 3d objects (@damariei)
- #60: Added [NX|XX] keywords to SET command (@damariei)
- #29: Generalized hook interface (@jeremytregunna)
- GRPC geofence hook support 

### Fixed
- #62: Potential Replace Bug Corrupting the Index (@umpc)
- #57: CRLF codes in info after bump from 1.3.0 to 1.4.2 (@olevole)

## [1.4.2] - 2016-08-26
### Fixed
- #49. Allow fragmented pipeline requests (@owaaa)
- #51: Allow multispace delim in native proto (@huangpeizhi)
- #50: MATCH with slashes (@huangpeizhi)
- #43: Linestring nearby search correction (@owaaa)

## [1.4.1] - 2016-08-26
### Added
- #34: Added "BOUNDS key" command (@icewukong)

### Fixed
- #38: Allow for nginx support (@GameFreedom)
- #39: Reset requirepass (@GameFreedom)

## [1.3.0] - 2016-07-22
### Added
- New EXPIRE, PERSISTS, TTL commands. New EX keyword to SET command
- Support for plain strings using `SET ... STRING value.` syntax
- New SEARCH command for finding strings
- Scans can now order descending

### Fixed
- #28: fix windows cli issue (@zhangkaizhao)

## [1.2.0] - 2016-05-24
### Added
- #17: Roaming Geofences for NEARBY command (@ElectroCamel, @davidxv)
- #15: maxmemory config setting (@jrots)

## [1.1.4] - 2016-04-19
### Fixed
- #12: Issue where a newline was being added to HTTP POST requests (@davidxv)
- #13: OBJECT keyword not accepted for WITHIN command (@ray93)
- Panic on missing key for search requests

## [1.1.2] - 2016-04-12
### Fixed
- A glob suffix wildcard can result in extra hits
- The native live geofence sometimes fails connections

## [1.1.0] - 2016-04-02
### Added
- Resp client support. All major programming languages now supported
- Added WITHFIELDS option to GET
- Added OUTPUT command to allow for outputing JSON when using RESP
- Added DETECT option to geofences

### Changes
- New AOF file structure.
- Quicker and safer AOFSHRINK.

### Deprecation Warning
- Native protocol support is being deprecated in a future release in favor of RESP
