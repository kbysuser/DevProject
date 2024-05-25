from easygui import *
from pprint import pprint
image_path=fileopenbox()
# 
# 
import piexif
exif_dict = piexif.load(image_path)
# print(exif_dict)

elat = exif_dict['GPS'][piexif.GPSIFD.GPSLatitude]
elon = exif_dict['GPS'][piexif.GPSIFD.GPSLongitude]
lat = elat[0][0]/elat[0][1] + elat[1][0]/elat[1][1]/60 + elat[2][0]/elat[2][1]/3600
lon = elon[0][0]/elon[0][1] + elon[1][0]/elon[1][1]/60 + elon[2][0]/elon[2][1]/3600
print('緯度経度は(%.5f°N, %.5f°E)'%(lat,lon))


