<?php
include_once("config.php");
?>

<?php
session_start();
if ($_SESSION["name"]) {
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Asociados Provalor</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
            <script src="jsFiles/myjs.js" type="text/javascript"></script>
            <script src="jsFiles/accounting.min.js" type="text/javascript"></script>

        </head>

        <body>

            <header id="head" >
                <p>Asociados Provalor: Bienvenido <?php echo $_SESSION["name"]; ?><br>
                    Codigo de Asociado: <?php echo $_SESSION["cod_asociado"] ?>
                </p>
                <p><a href="cambiar_contra.php"><span id="register">Cambiar Contraseña</span></a>
                    <a href="userLogout.php"><span id="chpwd">Cerrar Sesion</span></a></p>
            </header>

            <div id="main-wrapper">
                <div id="money-wrapper">
                    <ul>
                        <li>
                            <p><font size="6"> Valor: 
                                <?php
                                try {
                                    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $sql = "SELECT CONCAT('$',FORMAT(valor,2)) FROM tarjeta where codigo_tarjeta = :codtarjeta";

                                    $stmt = $con->prepare($sql);
                                    $stmt->bindValue("codtarjeta", $_SESSION["cod_tarjeta"], PDO::PARAM_STR);
                                    $stmt->execute();

                                    echo $stmt->fetchColumn();
                                    $con = null;
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                ?> </font></p>
                        </li>

                    </ul>
                </div>
                <div id="transactions-wrapper">
                    <ul>
                        <li class="buttons">
                            <input type="submit" name="accept" value="Aceptar Todas los Movimientos" 
                                   onclick="updateMovs()" />
                        </li>
                    </ul>
                    </br>
                    <style type="text/css">
                        .tg  {border-collapse:collapse;border-spacing:0;border-color:#aaa;margin:0px auto;}
                        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;border-top-width:1px;border-bottom-width:1px;}
                        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#aaa;color:#fff;background-color:#f38630;border-top-width:1px;border-bottom-width:1px;}
                        .tg .tg-z2zr{background-color:#FCFBE3}
                        th.tg-sort-header::-moz-selection { background:transparent; }th.tg-sort-header::selection      { background:transparent; }th.tg-sort-header { cursor:pointer; }table th.tg-sort-header:after {  content:'';  float:right;  margin-top:7px;  border-width:0 4px 4px;  border-style:solid;  border-color:#404040 transparent;  visibility:hidden;  }table th.tg-sort-header:hover:after {  visibility:visible;  }table th.tg-sort-desc:after,table th.tg-sort-asc:after,table th.tg-sort-asc:hover:after {  visibility:visible;  opacity:0.4;  }table th.tg-sort-desc:after {  border-bottom:none;  border-width:4px 4px 0;  }@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}</style>
                    <div class="tg-wrap">

                        <table id="records_table" class="tg">
                            <thead>
                                <tr>
                                    <th class="tg-031e">Movimiento</th>
                                    <th class="tg-031e">Transaccion</th>
                                    <th class="tg-031e">Valor Transaccion</th>
                                    <th class="tg-031e">Mov. Aceptado</th>
                                    <th class="tg-031e">Fecha Mov.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $sql = "SELECT movimiento, transaccion, valor_transaccion, mov_aceptado, fecha_mov FROM movimientos where cod_tarjeta = :codtarjeta";

                                    $stmt = $con->prepare($sql);
                                    $stmt->bindValue("codtarjeta", $_SESSION["cod_tarjeta"], PDO::PARAM_STR);
                                    $stmt->execute();
                                    ?>
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <tr>
                                            <td class="tg-z2zr"><?php echo $row['movimiento']; ?></td>
                                            <td class="tg-z2zr"><?php echo $row['transaccion']; ?></td>
                                            <td class="tg-z2zr"><?php echo $row['valor_transaccion']; ?></td>
                                            <td class="tg-z2zr"><?php echo $row['mov_aceptado']; ?></td>
                                            <td class="tg-z2zr"><?php echo $row['fecha_mov']; ?></td>
                                        </tr>

                                        <?php
                                    }
                                    $con = null;
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <script type="text/javascript" charset="utf-8">var TgTableSort = window.TgTableSort || function (n, t) {
                            "use strict";
                            function r(n, t) {
                                for (var e = [], o = n.childNodes, i = 0; i < o.length; ++i) {
                                    var u = o[i];
                                    if ("." == t.substring(0, 1)) {
                                        var a = t.substring(1);
                                        f(u, a) && e.push(u)
                                    } else
                                        u.nodeName.toLowerCase() == t && e.push(u);
                                    var c = r(u, t);
                                    e = e.concat(c)
                                }
                                return e
                            }
                            function e(n, t) {
                                var e = [], o = r(n, "tr");
                                return o.forEach(function (n) {
                                    var o = r(n, "td");
                                    t >= 0 && t < o.length && e.push(o[t])
                                }), e
                            }
                            function o(n) {
                                return n.textContent || n.innerText || ""
                            }
                            function i(n) {
                                return n.innerHTML || ""
                            }
                            function u(n, t) {
                                var r = e(n, t);
                                return r.map(o)
                            }
                            function a(n, t) {
                                var r = e(n, t);
                                return r.map(i)
                            }
                            function c(n) {
                                var t = n.className || "";
                                return t.match(/\S+/g) || []
                            }
                            function f(n, t) {
                                return-1 != c(n).indexOf(t)
                            }
                            function s(n, t) {
                                f(n, t) || (n.className += " " + t)
                            }
                            function d(n, t) {
                                if (f(n, t)) {
                                    var r = c(n), e = r.indexOf(t);
                                    r.splice(e, 1), n.className = r.join(" ")
                                }
                            }
                            function v(n) {
                                d(n, L), d(n, E)
                            }
                            function l(n, t, e) {
                                r(n, "." + E).map(v), r(n, "." + L).map(v), e == T ? s(t, E) : s(t, L)
                            }
                            function g(n) {
                                return function (t, r) {
                                    var e = n * t.str.localeCompare(r.str);
                                    return 0 == e && (e = t.index - r.index), e
                                }
                            }
                            function h(n) {
                                return function (t, r) {
                                    var e = +t.str, o = +r.str;
                                    return e == o ? t.index - r.index : n * (e - o)
                                }
                            }
                            function m(n, t, r) {
                                var e = u(n, t), o = e.map(function (n, t) {
                                    return{str: n, index: t}
                                }), i = e && -1 == e.map(isNaN).indexOf(!0), a = i ? h(r) : g(r);
                                return o.sort(a), o.map(function (n) {
                                    return n.index
                                })
                            }
                            function p(n, t, r, o) {
                                for (var i = f(o, E) ? N : T, u = m(n, r, i), c = 0; t > c; ++c) {
                                    var s = e(n, c), d = a(n, c);
                                    s.forEach(function (n, t) {
                                        n.innerHTML = d[u[t]]
                                    })
                                }
                                l(n, o, i)
                            }
                            function x(n, t) {
                                var r = t.length;
                                t.forEach(function (t, e) {
                                    t.addEventListener("click", function () {
                                        p(n, r, e, t)
                                    }), s(t, "tg-sort-header")
                                })
                            }
                            var T = 1, N = -1, E = "tg-sort-asc", L = "tg-sort-desc";
                            return function (t) {
                                var e = n.getElementById(t), o = r(e, "tr"), i = o.length > 0 ? r(o[0], "td") : [];
                                0 == i.length && (i = r(o[0], "th"));
                                for (var u = 1; u < o.length; ++u) {
                                    var a = r(o[u], "td");
                                    if (a.length != i.length)
                                        return
                                }
                                x(e, i)
                            }
                        }(document);
                        document.addEventListener("DOMContentLoaded", function (n) {
                            TgTableSort("records_table")
                        });</script>
                </div>
            </div>

        </body>
    </html>

    <?php
} else {

    header("Location:index.php");
}
?>

