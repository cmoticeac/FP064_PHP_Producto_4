## FP064 PHPDevelopers Producto 3

1. Haz el build del docker: docker-compose build
2. Corre la composición de docker: docker-compose up -d
3. Instala las dependencias con docker: bin/composer install
4. Accede a tu navegador http://localhost/


Camelia-
- En los middleware he pueso la explicacion en castelleno. (no he tocado codigo)
  - falta agregar las Url que pueden ser accesibles aunque este en modo mantenimiento (preventRequestsDuringMaintenance.php)
  - falta agregar las Urls que esten exentas de la verifacion CSRF (VeifyCsrfToekn.php)
- He modificado dshboard.blade.php porque esta en plantilla twig y he agregado codigo en calendario.blade.php
