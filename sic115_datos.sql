-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2025 a las 06:11:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sic115`
--

--
-- Volcado de datos para la tabla `asientos`
--

INSERT INTO `asientos` (`id`, `fecha`, `numero_asiento`, `descripcion`, `tipo_asiento`, `created_at`, `updated_at`, `total_debe`, `total_haber`) VALUES
(1, '2025-10-29', 'D#002', 'Venta de mercadería en efectivo al costo', 'Diario', '2025-10-29 16:49:18', '2025-10-29 22:52:14', 55.00, 55.00),
(2, '2025-10-29', 'D#001', 'Compra de Mercadería al crédito', 'Diario', '2025-10-29 18:04:06', '2025-10-29 22:51:32', 100.00, 100.00),
(3, '2025-10-29', 'D#003', 'venta de mercaderia, pagan con cheque', 'Diario', '2025-10-29 23:24:56', '2025-10-29 23:24:56', 25.00, 25.00),
(4, '2025-10-29', 'D#004', 'se realiza prestamo a banco agricola por 1000, depositan en cuenta bancaria', 'Diario', '2025-10-29 23:29:08', '2025-10-29 23:29:08', 1000.00, 1000.00),
(5, '2025-10-29', 'D#005', 'Se compra mercaderia, se paga con cheque', 'Diario', '2025-10-29 23:39:06', '2025-10-29 23:39:06', 300.00, 300.00),
(6, '2025-10-29', 'D#006', 'Aporte de capital social de los socios en efectivo', 'Diario', '2025-10-30 03:39:08', '2025-10-30 03:39:08', 900.00, 900.00);

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `padre_id`, `codigo`, `nombre`, `tipo`, `naturaleza`, `permite_movimientos`, `saldo_actual`, `created_at`, `updated_at`, `es_mayor`) VALUES
(8, NULL, '1', 'Activo', 'Activo', 'Deudor', 0, 2000.00, '2025-10-28 02:22:35', '2025-10-30 03:39:08', 1),
(9, 8, '11', 'Activo Corriente', 'Activo', 'Deudor', 0, 2000.00, '2025-10-28 02:27:32', '2025-10-30 03:39:08', 1),
(10, 9, '1101', 'Efectivo y Equivalentes', 'Activo', 'Deudor', 1, 955.00, '2025-10-28 02:27:59', '2025-10-30 03:39:08', 1),
(11, 9, '1102', 'Bancos', 'Activo', 'Deudor', 1, 725.00, '2025-10-28 02:28:52', '2025-10-29 23:39:06', 1),
(12, 9, '1107', 'Inventarios', 'Activo', 'Deudor', 1, 320.00, '2025-10-28 02:29:32', '2025-10-29 23:39:06', 1),
(13, NULL, '2', 'Pasivo', 'Pasivo', 'Acreedor', 0, 1100.00, '2025-10-28 02:30:05', '2025-10-29 23:23:22', 1),
(14, 13, '21', 'Pasivo Corriente', 'Pasivo', 'Acreedor', 0, 100.00, '2025-10-28 02:30:37', '2025-10-29 23:22:58', 1),
(15, 14, '2101', 'Cuentas y Documentos por pagar', 'Pasivo', 'Acreedor', 1, 100.00, '2025-10-28 02:31:15', '2025-10-29 19:39:31', 1),
(19, 13, '22', 'Pasivo no Corriente', 'Pasivo', 'Acreedor', 0, 1000.00, '2025-10-29 23:26:20', '2025-10-29 23:33:16', 1),
(20, 19, '2201', 'Cuentas por pagar a largo plazo', 'Pasivo', 'Acreedor', 1, 1000.00, '2025-10-29 23:27:20', '2025-10-29 23:29:08', 1),
(21, NULL, '3', 'Patrimonio', 'Patrimonio', 'Acreedor', 0, 900.00, '2025-10-30 03:35:39', '2025-10-30 03:39:08', 1),
(22, 21, '31', 'Capital', 'Patrimonio', 'Acreedor', 0, 900.00, '2025-10-30 03:36:55', '2025-10-30 03:39:08', 1),
(23, 22, '3101', 'Capital Social', 'Patrimonio', 'Acreedor', 1, 900.00, '2025-10-30 03:37:29', '2025-10-30 03:39:08', 1);

--
-- Volcado de datos para la tabla `libros_iva`
--

INSERT INTO `libros_iva` (`id`, `asiento_id`, `tercero_id`, `tipo_libro`, `fecha_documento`, `tipo_documento`, `numero_documento`, `concepto`, `monto_neto`, `monto_exento`, `iva_credito_fiscal`, `iva_debito_fiscal`, `iva_percibido`, `iva_retenido`, `total_documento`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Venta', '2025-10-27', 'Factura', '123-125', 'de ejemplo', 591.15, 0.00, 65.00, 76.85, 0.00, 0.00, 668.00, '2025-10-28 04:42:28', '2025-10-28 05:49:12'),
(2, NULL, 4, 'Compra', '2025-10-27', 'Factura', '21342542', 'de ejemplo', 100.00, 10.00, 13.00, 0.00, 0.00, 0.00, 213.00, '2025-10-28 05:11:25', '2025-10-28 05:46:49'),
(3, NULL, 4, 'Venta', '2025-10-27', 'Factura', '26', 'concepto nuevo', 1000.00, 0.00, 0.00, 130.00, 0.00, 0.00, 1000.00, '2025-10-28 05:43:27', '2025-10-28 05:46:06'),
(4, NULL, 1, 'Venta', '2025-10-28', 'Factura', 'dfwr', 'asdad', 132.74, 0.00, 0.00, 17.26, 0.00, 0.00, 132.74, '2025-10-28 06:10:22', '2025-10-28 06:10:22');

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(9, '2025_10_27_091652_create_terceros_table', 2),
(10, '2025_10_27_091655_create_cuentas_table', 2),
(11, '2025_10_27_091710_create_asientos_table', 2),
(12, '2025_10_27_091713_create_movimientos_table', 2),
(13, '2025_10_27_091716_create_libro_ivas_table', 2),
(15, '2025_10_27_231344_add_concepto_to_libros_iva_table', 3),
(17, '2025_10_29_111457_add_totales_to_asientos_table', 4),
(18, '2025_10_29_132911_add_mayor_to_cuentas_table', 5);

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id`, `asiento_id`, `cuenta_id`, `descripcion`, `debe`, `haber`, `created_at`, `updated_at`) VALUES
(1, 2, 12, NULL, 100.00, 0.00, '2025-10-29 18:04:06', '2025-10-29 19:09:42'),
(2, 2, 15, NULL, 0.00, 100.00, '2025-10-29 18:04:06', '2025-10-29 19:09:42'),
(3, 1, 10, NULL, 55.00, 0.00, '2025-10-29 18:36:02', '2025-10-29 19:05:12'),
(4, 1, 12, NULL, 0.00, 55.00, '2025-10-29 18:36:02', '2025-10-29 19:05:12'),
(5, 3, 11, NULL, 25.00, 0.00, '2025-10-29 23:24:56', '2025-10-29 23:24:56'),
(6, 3, 12, NULL, 0.00, 25.00, '2025-10-29 23:24:56', '2025-10-29 23:24:56'),
(7, 4, 11, NULL, 1000.00, 0.00, '2025-10-29 23:29:08', '2025-10-29 23:29:08'),
(8, 4, 20, NULL, 0.00, 1000.00, '2025-10-29 23:29:08', '2025-10-29 23:29:08'),
(9, 5, 12, NULL, 300.00, 0.00, '2025-10-29 23:39:06', '2025-10-29 23:39:06'),
(10, 5, 11, NULL, 0.00, 300.00, '2025-10-29 23:39:06', '2025-10-29 23:39:06'),
(11, 6, 10, NULL, 900.00, 0.00, '2025-10-30 03:39:08', '2025-10-30 03:39:08'),
(12, 6, 23, NULL, 0.00, 900.00, '2025-10-30 03:39:08', '2025-10-30 03:39:08');

--
-- Volcado de datos para la tabla `sessions`
--

--
-- Volcado de datos para la tabla `terceros`
--

INSERT INTO `terceros` (`id`, `nombre`, `nrc`, `nit`, `giro`, `es_cliente`, `es_proveedor`, `es_gran_contribuyente`, `created_at`, `updated_at`) VALUES
(2, 'Cliente 1', '123456', '12345678-9', 'giro2', 1, 1, 0, '2025-10-28 04:16:26', '2025-10-28 04:16:26'),
(3, 'Proveedor 2', '65432467', '09876543-2', 'giro 2', 0, 1, 0, '2025-10-28 04:17:27', '2025-10-28 04:17:27'),
(4, 'proveedor nuevo', '1231', '12355-0', 'giro 3', 1, 1, 0, '2025-10-28 04:59:57', '2025-10-28 04:59:57'),
(5, 'cliente nuevo', '21324', '2342542-435', '23424', 1, 0, 0, '2025-10-28 05:44:11', '2025-10-28 05:44:11');

--
-- Volcado de datos para la tabla `users`
--
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
