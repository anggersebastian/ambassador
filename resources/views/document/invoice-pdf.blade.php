<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice PDF</title>
    <link href="https://fonts.googleapis.com/css2?family=Francois+One&family=Roboto:wght@300&display=swap" rel="stylesheet"> 
    <style>
        body{
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    
    <div class="container" style="width:600px;margin:auto;">
        <table style="width:600px;font-weight:bold;">
            <tr>
                <td style="text-align:left; font-size:20px; font-weight:bolder;width:700xp; padding:10px 0px;font-family: 'Francois One', sans-serif;;">INVOICE:DRP123</td>
            </tr>
            <tr>
                <td style="text-align:left; font-style:italic; font-size:12px;">Date {{isset($order['created_at']) ? $order['created_at'] : date('Y-m-d')}}</td>
            </tr>
            <tr>
                <td>
                    <img style="width:240px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPwAAAD8CAYAAABTq8lnAAAgAElEQVR4nO29eZhU1Zk/3t00DSq4RI3LuG9E4xIdx5gYjTGjRpNoZmLcEzWTqImZPDHzZDRff6OssqNRRDSYMYg4cQFUFAxGjYp0NzTdNA1CgzQ7NM3SC71X3c/vj+6qvnXq3c6tapXqnOe5T926590+73nf95y71K08CC0IAnJfo40iKwiC5PHwvsvDfVIyODs0W6M2TbfEF8UmX+xRm499veFbKV44H1DfrbIpPVHtzLRlG3ueK1hKNN9EzaRgREnYbAY8hcsHDyfPglPzOcWbTds0rJbiK9lK6aVkUf0aRisdZUP4uyZvX8Wex82UFgWU8T78FJ0E3v0uVTWOTpJLfXLHuL5s8Us+kXBIOn2LRzZsk/itfZJcH39b4jDXsedBaFqihxVbaK3N4gDf/mzqytQGy6zwWbXesMlaWDORnw3evoA9zwrYOktzNNnQk2kVj6JX68sWf5jOdzbIpg0+/NlKkE8jBjk9Ucd2X8UuzvBWIeF9zTnWfW4JQy1pJDpXps+ga8VD0q/Zrh13+zk8mt0+MiTf+PrX95PSy2GkMEUtllRfLmPPCwvhALg02r52jAJH7VPNIktLMM4pUe3S+CUaiVaS4WMv5w/KFk4vNx4UjSUGrDFm0Wu1Q6PvC9jZGZ4TRhnJJYPkBB8gVh4toDnHu/tW2ygeiwyfZpHP+deKzToeWgHLVL5vvzXg/4G9p6XdlnMZJIHuPmeghVarbhwY7TiHyTfZNVxWHtceHz7JXskWKfClsbP2UTZpvD60HK8loX1kcbS5hJ1c0nMKw8c0hZbKKgH3KSSUXZw+qYhZdWn6o/Jq9lr6LLTauFjstPjNkkySzVKfT7BzNlkSTNrfF7GbLtppiZ8JPydLSyBL4kp9Eo8PjWS/lZ+T4fZJ9nH0UTFaCwSl11pgMg1+7biLy7fPYiMl7/OM3fsqvaXCaAlAVSpLYFpka7I0GktF9il22WhRimqUWSBKIFnty6RFTboo8SDpzgXsasJzlcs95jMTUt+l2YpzulRQOB0aPWcrhdEyc2j0Fn0aFhcPpZeTFXX280keKk6s+DQ9UqJy8dWXsee5hBSjTxJHbVrCuv3UwEgyom6UHyTd4e+Ufgu95heLfk63q8/qR5/vXDBbZWt+kHh8dPdF7OptOS6QOEPcPnffwsuBsgC2JB5nEyXL1U3RSfuSLVLj7Ob4LQmt4eX4NVtdGVFsleLIYqsl6Tib+xL2tIT3YaaCipNnAWCRaxkAjS9q4mVii68+qaBp8rVCSumy2K71RZHD2cXFoMRP8fgUOqvN+zJ27xme2+c+qQD05dMKiaVRNkjJK1V6a1JZC6SU3FriawWV4pFs02RKYyP5WIoDTr8VuzWpJFv6Cnbzk3aWfgsPR+PDqw2UxG9NTk2+NXk4Wyx0kkwpgCg6zUYfDJouzkbqM0rzCfYwD8ffl7CnPHhjCSBXAPWdo5eqanif06/1cbZJOqlP3wCw0EuVW2paxc9Ehs+4SPokHqnfOltFmVystH0Ne174IJf0XBJxhYJzlkRLHZcSlLJFouXk+xQP7pjUZykymm7fYuRbVCTbfOVEkZ8t3dZ49LEtG+3zhD1PCnotMXwMk+S5+1wx4PrDxzl66jhlX7hPs5Hj57BTx7ljnN2uTGtxsgaZj07LcYttnI2WGPCVz/H0Fex5LoFmDNeslSkKEK5YSInNBbNP8dAKh/ZJ4dZ0Sj6zYNH4OTmZ+pij17Br8WL1hQ9vX8ZuumjHAXGF+RrhQy8FM/VdSjpJJifP1y4rTabYLfZRBeLTbJnqlsYpU//3dvu8YY/8xhvfINKSSwPhU4DC9lnofFomeLOto7dlRNWZiU8zGR9Xf1R7orR9Bbv4aG1vtKgzZrZmeE5GFOd+1vQ+RZejy9S2bBRAbnUo6crGqqUvYo/0aznJECufe9y61NZm+sS+NuNrcsP0Vhu5ls0lNRUgliLn0nP+oTaLzGzhko5notflpfzRF7CnXaXngsH9zjmF6+OM14y08FDB79riypB4KByWxNGS0VIwfAqPJEPDIflOCnYf3Rw2Lb4kGl8bNXv6GvY8itg9ZnUgx2MBaE1KDazGY8FiSWrquyVZLc2HV0psq07N5z52h+W4eDgebdP0SbJcuzSbcx07++MZzVhXqeYoS3K5ciz0Gp/FHkkepyMKnWY7Z59Fl9R8AkezR8MUxadUkFr4fZM0qj9zCXvafXjNSIkmalWUZHFApT6uwkmOlXRzvNbCQunj6LRjnO0W+Zr9Pr71CThJJsdrKZoaZqv9fQm7+NZarc9aKDhDLcBcOotOTZ+vLM4uS/MdICkwKBmaTJ+CE7WQcPJ9YiUKv0+/RXdfwG5a0kvVjQMgAbI6wye5LIUkiiyqz0Jr5ed0W+3l/Kgdp/alwLfYwH3XmpZ4Vr2UPOrTpe1L2MkZnhISJfElGS6dVCQ4eqk4Sfot3yk8mQyOtYhYgtXXdo7eYjtlFzeGEm8m2DPVz/FbEjpT3Z837N5/RGFNcmtQUfI4QL5ByunSkpPSJdkpybHqjcJvGQeKnxsri9+lY1yfD631WCZjKcnJdexpCS/NBlzSU7RSi1KlJFrOXiu/RBdlRpBscz81eZKfrPxSAef0SbZYaDUZmfAm9qPIkHT3BeziVXpXYaYGZzLDZUuHb8Xl7PHBE1Wnj+xs2KLxcZuvrZnakk0ZPrGfC9jzXOO5WYgDyy0duJWCdTaOCjBq9ZMGkxssDp/EZymcmc68Up+0UpACWVudcFglfpcuk5mLar4TRV/AniclrGQcJ1RzmOY8Sb4lQTg8nC5KFjVg3DHOFolfS3iNn6KRjkvB7PZbC5I1MVz6TPskTL5jwuHPZexpMzxHSDnGNc5qJEXv6uV0a7Q+/Fyz4tOSiOPVdEv8VnkW2ym83DhyvsyW3zl+Tp4FO2evxbcStn0Ze9oM75tkPg7gjJMcxn1Sci36ue8UDhdneF9LPi2QLHy+x315rLSUn6wFxG1UHyXb7aOaFPzWJNT8l2vY2SU9p9TXMMmYz1OTBoqijSpb4822f7KNpzfGL1OZn1ZM5QJ28ffwWiWUKpn73aeqUkXIwsvxSLZK8qVjki5fm115FjqrPZxuywxkmRmt+rl+iZ7icfH4jIG031ewk4/WWoVoyeUDlpPjystEbtSZLBP92uBoxy2F0dcGLVilQqp9ZtIk2a79PoFPYbf6QrOL4/Ftnxb2PPcgJZSjoQzmQEhGWoymbJD0cDSarZZ+Vxc18JrNXOOCk5Mt2czZrem32KV9t+jmYs4iwzfZLHHXF7CnXKWXgtjSRwGwyLcmhyUpuYG1ypaS2EJrGaSovuRkcnb64JHGJqpuzR4uBlxal9/91PRr496XsJvvw3OKpWTm5PoC4/RyOiS7LQOkDb7mcKngWIqPK1vSz/Fa9FvGUbJBSxDXHisPp5/7tMTrP7B3beR9eE0ZRasp15wpNUqWRKvJk+RI9lkdzNljxer619JnkecbQK4MX+zucUs/N9Y+MWCVn2kCWuz5vGEX78NbhbnHMjEwEx5KvzXhLAWP47cOVlQ7ovrCR4aloGv2Ssdcea5sadw0u6Mkk4UuF7GTCU8FqUUhB0JKFA2Qz/EoTaroPvQW26x2a8UlikyJN0qw+TZff1oDPputL2A3/z88VRgsLVM+ibc3CgKXvD6Jzcn0tSuq/ihFwYent5IiG4Uzk/jKpnyf9mliJxM+GzOzdaPk+VQ6yf5sNG4Fo+lxfcjxatgzxSIVsEzkSXGRyacP9k87PnIBe9ptOQ2Ia5wlOa0ztAtYcgpnK1UtOTmcHRKtlUfDIw0wh0NqXL8WQJQOX39JhYyLFZ8tCm5Lv2Z3LmIXr9JTSrlAtSrnQHGB7wOIGxwpuaLa55OolgCw9FswSTIl7D6BJ32X5Ev2cT602Kvx/gN7z6fpthxnJKeQMzhqQFuD1yJbcraEV7KD4ufs0XBoclw6X/s1e7igsSaF1Q9SPFmDV/OTj/19Bbua8C4Yd18C6/ZrNJpsiUay3cJn1eXjJx/brPo1eq6fChifxsWIj099sXFyfNs/sIdmeEqgFYgGOgpIi0wfnb76NR0UJotOSyHrreZTaKyF+dOwySonW3b0BeziVfpPw5BsOzXThM92Ecs2ve8Kw13ScTo5mmwGvlZEfeMmm4nTV7Czv5ajFHDfJcPcfW2JmY0lsXV2tjbXwb7OzjRwMg3ubCQHVRR6e4XiU/yypYOjyRXs6j/PZGsGsy5ppSJhaZkMCscrHaNkcP0WfonWIpMqqL5F1ootWzHj2681yU9RJ5xcwe590Y6b6XwcKcmwzEYaKK5fspFLMMo31sZho+REKXS+RcPiUwm7jy2SbkufJbF8/MnFtFQkcxG792uqLY6jAGjO1ZwjOcICnPrO9WlYpOPWTyu/r35fuWG8lnGkjlPysmF72Lao/BJdWH5fwW76u2gJlJSgEp/FQJ+EDfNog2exjauSlgSi+jmfckVO0y/RS/otPtDstGCSPl06jU+yN6r+KAXRpdsXsbNLegqoFvhaskr8nCN8nSEFteZEzh7KZs3hEr9P0/glX1L8FputtkTB49OsSRJVno+MXMEuXqWXEpsLbEqeZDCllzPWZ3Aou3x4OBpLMZFkWfwg9Ut+p3iykRQ+x7OlL1P91skhig5ffqt+X7oo2Nk/k5RmKorWMgNmozr2Fr9PUbEEUVQbe3vm8NHJTQIav68vPwvMmu5cxS7+Hp6a+X2NpFYJXL8mx3rc175st2wlvcb/aQeLZUaLkhwUn8b/aSdLrmBPuWhHJafFiDCv1bCoy03OTh+d1GqEw8Ydtwy4dTVk4fcpeBydtArz0WWxmfKvZINmn8UeCy2135ews4/WWhNJC1ItIC2BbJXB6Zaqa6a2cf2cDzUait5ivyWIJZ9SPD401sDWaFzZGi7fOKX2+xJ28a+mLMIkg3xkckFtrXqUI63ytETgvnP6tOCy0kv2a8etsq1FJ5vHM8Hga2cmLRexq1fpOYE+iaLJsRiuVT0u4d1+DoPmNK0QaM2nkGj8HBZJtm8xdmm1ImYtxD783HhK/FY5lCyKj+Kx2M71f9bYxVdc+QaG5iCKxwekDzhJXyaVmNPpa0+UwqQFj8U+H5usdkl6JT0WHZw8KW4lfZJujjaXsOdJnZqxln5rUFK0mnMsyULptVRGSoak34Ldh18rhj6FUMNioXP1agnA2UjJsI4nx29plsTqC9jzKMYolctHsWaU+0kVjWwnvWaHyyfp0rD5NAk/ZQ+n21eny2sdn95okm6XhuOVaCRdmv59DTt7W04SRBmjgc9GseCS3GKvljgUPffdksC+tkWRpxVFilZqlsJhKTi9lQRUvPlg98FlodkXsatX6aUZkAskrgpxQapVTK3KWZ1tqcySnRyNK1+zX8NmSVhfGmtRsYyBz9hJNkt2SnQ+SUrZ7B6XaFw9+zr2tF/LWQxzhVmaFJCUgZINUnXLxPmavZLdnFwpkHzkWXzkYxdnJ2dzlCJrKVJWXsouLdjd7xZ/5jr2jN94E5WWM8haWLRqa6G3FiGLXdYg4IJJorfYpx3j/MTp1Y774JBkWOgsdliKfJRElXRabJVk+NrA2eGDPe2iHZUQWuXgkstigFUuNVg+jrYksobDp5/q8wmaKD704bHo13T5YMvGd812KVm5GIga3/sq9jwKEMWUjWZJOspIy3HOTu6YyyMlLqVHcjBHrw0OZaMVm6WIahi04NOOSQVE4tWwSDTW2PQd01zFnmdxhGaMu8/1+xQXS4Jw8rVqp7WohUVKOil4pCCyyLPSa+Ml0Uo+sYytpThptkq2ac1aHHMde9ptOc4Ii3GUAossitdaiLhPTbcFryVRNXoNoxYoms1aYdL8wtFxNmpFT9IhyecwSMckGouPLbGUa9jFF2BQhkmbBbxmtEYnBScn1xr4Lr2USJRd1mYpTppMnwCjjnM+ooqYJtvHXs13Ft9axlfybV/GnnYObwliToklgKVCQcm32OVTODTdLh2HhePjZIX7fRNeS1TJDi6IqHGXgl6zVaLRMEmfElYfGi4GqWO5jD2PAujTrMZaKmeYVuOX6Fx7LLisSWLpjyJfoqNoLQVR8rfFx5ZPDY+rT0pACo8VlzV5tGTPdexpT9r5JL1vgfBJPEuAS86yyLcUA2kwLFXWxzYfnqiyovD1lpywPB892dTt2/Z17OqDN1SfT5JpM7FVvkSv2Wul7a1A6s0i6vJkgsFnxZH4rhVAH91R4sSqk5Kl+S0XsbMX7ayCstEymaWzaY/PoPfG6saHNrxC0QY/G3Zb/JCNYiMlJXW8N4t7LmI33ZbzFa4p9Q1Oqw1a8PuuRDQbfR0eNcjc75RfsrnqsdqXzRURFcjSrJzNuPSxkbIrG3I/LexqwnOGaXTaMW52cgFzICWHWGzi5FN2SDKk5sq3FCJtMC2zgSTDQmcd40x8Q9FaA9oyzpbx85UdptlXsbPvtNOqi1WpK4NzFJUcWrJIhYLrlzBwMjINHgq7S+dTvDhbfGYEzp+WsfYpOj7NVz93jPKfFk99Bbv64A0VtJpSDRhnDHfcmrjWgZSKj1RsKF4p8Vx6a6GRgpOSydnkOyZa0GnYJRu0YmfBzvnIqp+SZcGWS9jJP5N0BXHKpETUglTis4B37dTAW/ncPouDObmSDIqH87dmv5awlsTn+KQY0GJDs9+C3SfeNP1a4vUF7CkzPGWglqASEOm7VRYnRzsuYZGSQrPbip+yy4fe2m+l9xkrjobCng1MvdWsPveVsy9jT1vSS5UFANpjATY3duCDTU14onwnxpXsELcJpTvw3IrdqKhtwa6WTsTidmcBQCweYGdLJ8prW/Dnql2YUOrqqMW4Rdt6d/vIto1ftA1PLd2B11bvwbLaZuxpjaGxPYa2zrhX8GkBxc1GkrxMA4+aebKVUK4Od9/a31stl7CLF+1SjwGtnXHMW9eAa2bV4LxnV+PIKStx2BMr6G1y13b4Eytw/FMr8Y3n1+CeBZtQUduCts64yQHtsQArd7biZ/M34qIZq3HclCoc/vhyHP6Ys/2hEoc9usy+PVJBb5PCW3nPNpHZJixN2Q6fsBRHTSrHKY8vwzlTl+PqGatw+2vr8H8rdmFLYzsa22JZnxWyMcNb9UQNeouNUZLImgTZWt3kAnbySTuKuT0Wx3MrduOUqSuRP2EZ8sYvQ94EYRtfkbqNq8D+j1Tiyhc/wYL1jeiMy+BiQYDiLXtx9YtrUTS+AnljliJvbPc2xt3KkDea2R4uQ97DS9K3UUuQN2px6jYyvJX2bCO4rQR5w4ltWPc2tBj9Rpbii+OX4oKnl+OBdzejsrYFje0x04BaG0WbyTFOhzXwffRkYpOVP2oxcPlzAbvp0dpYPMCSbc048ckVPYk+sbL7s3ubUNl1LLGfUgAqurbxFRgwYRl+OLsGn+xpZ0EEAbClqQM/fn09CseUI29seVeij+v+HFvesyWSfnQZ8kYTxWB0GfJGL+neLEXAKQQjS7sKwIjuQjCi1FgMQgVhWDHyhhZj0MOL8eUplXikZDu2NLYjFrcFDNe0Iu0rz6LLDXSfmSkTrJI9vd1yCbsp4fe0xnDLGxvQz53FJ1b2JP4EpxBQK4DxXdt+4yvw7PJd6IzTVTIeBJhRtRsHTFzWldTjwglfjrwx3d+Tn2U92+iynlk/mfDdCZ6W8N1JLSV8IulHEEk/oiQ9yYcTx8KJP6wEB44sxc2vrMXfNzSiuUM/veGaO/DW5X1UXVSwZzIjZWKvr+4oOlxduYDd9Cz99r0dOPOZVaHkDc3mE0OJHy4AbsInlvYTliFvXAVue3MjNjXSs3xrZxzDPtzWNWOPq+hJ+nHhmd2Z4RPJnUh0boZPm9mVhE/O8KU9y30y4bn97iIwvDgl6QeMKMXF/7sSM6t2obE9hqix61vtowZKJuexnO5PK2Ez5c8l7HnhgOGAVO9uw8lTV6bP2BOdWT65X5mczallfd74Cnzt+TUo295MGrWzpRN3v7WpJ+HHlSNv3NLUhB8bPqcv45M+eT6/pOczPMNrS/pRxHn9iMWpy/nhlhm+uGsb1jPbF40sxbl/rMJzy3dib0fcewA/q2VtVJ3ZkMHJ6s2WS9jZf54JC6upb8dpT39MnLtXhmb7yvSET8zsyYTvOXbhjGos2Zae8EEQoKEthl8v2IS8h6WEJ87h0y7mCQk/yjjDp13Mc5NfOH9PFgD3wl4i+YvRf0QpLpy2Am+ta0BHTH/mwT1GFWnLvjbmnD6Nz0e2Zd+qM2oSSDhzEXueS0zN8LtaOnH+n6t7lvPu7O4mfvJ8PTGjOyuDcRX4yZsbsLGhZ0kfDtxYPMAjpbVdCT+2wjmHdy7aJWZ499zdXdI/HF7S+57Dh7YRbsKX0DP8cHeG567oF6NoRAm+P3M11u5uQ1xIbK5lo5/7zq0ApRUhpUsKbmvBstjO0XA29TXsZMK7xM0dcUwo3YEBk4ile+KTSnh3Zu/+fuAjlZixYnfy1hyl890NTThx6oquc/Vxzjn8GHdJH17Kd1+tH+3O8GXEkt5yDh9O8NC5/Agm4cmLeFSyh5b4w4oxcGQpfvPWBtR336unAkk77stjpXU/XVoqaLUk0xLL7aOaVMi0JKPs6QvY1fvwCcG1zR244i+foCA8W4fP3bmr9hNCM/z4ZTjgkUpc/+p6VO9u40Gj68LdhJJaHDhxWU/Su8v55AwfvlIfvjdPLenL5HP4kYv5GZ68cGfZQhftmC1/WDHOerISb31Sb0pQym9S44LUEqDud8usxsnynS2loKaSz4JbSthcx84mPGXAip2t+PdZNRj46HLkjQvP4pXp23hnWT+2Agc+uhzXzKrBgvVN7CO2YQN3NHdi6AdbcfTjy1GQSOzE7bjkthTkbbiUh2+E+/Dckt50nt69dHcTODzrp8zwVNIXJ4/3G1qMX86tQVP3gznSTKAFBTWumTQpuLKhwzK7Sp9RdPjw5Qp2rzfexIMANfXtGLVoO25+fQPOm16N055ZhVOlbdoqfOXZ1fjh7BpMKt2BZTta2KfsqKra2B7DM5U78cu3NuGi56sx5I8rcepTK8zbCVOW45BJFcLTd27CL0bhw0vwT3+owGlPLscpUyrl7Yme7eTJy3D4xKUYMLIU/RJX49kZnvg+tBinPlaBN9fWI0B6kmvB1pvJb5mdogamJkOLSx8MlmOcfbmAXX2WnlLeGQ+wtakD72/aizfWNWCutH3SgPc2NmFjQ8+TZb6BGg8C7GmLYcm2Zszrlpnc1jbgjbX15Pb6mnq8XdOIf52xGvkPOzN+IsGJJf2JTyzHpJLteGNNPd5Yswdzjdur1Xvw7LI6PFKyHbe/tg6HjS9DwXDlop2zFQwtxoj3tyQfSuLGx/WbtPzz8bW2jAzvS98turmYs8jwDfpMCmYuYVd/HisxWwIuzMMFrkuryaScxbWOeIB//8uarmQmz+GdGX7EYlzefcXc6g/XjngQYGNDO55augPnPVWFAjHJi1M/hxbj1llrsaWxwzzwFhsTWzweT9lisVjaFo/HTeNlDW4f33HBz/FEmeWiHM8V7Ox9eKuRPnzWfct3i31B0HVK8M0/f9yd8EuYc/jFPQk/rBS3v1aDnS2dpA0+uPd2xDGzahfOmFKJ/GHyRbvkNrQYp01ehjfW1Hv5ifoMggBtbW1obGzErl27sG3bNtTU1KC6uhpVVVUoLy9HSUkJFi1ahI8++ggfffQRSktLUVVVhU2bNqGpqQl79+5FW5ut+EVpmcj1HY9PS5aPzkx4o/Cn/T+8VZhlRpdoM5Gv0YeDvqa+HV95eoVzH34JP8MPK8X972xCeyz9yTcuqSTcO1s6cfPstV2z/LDwbM6d0xdjvxElmF65M5KPwrY1NjZi5MiRuPTSS3HRRRfhggsuwHnnnYdzzjkHZ555Js444wwMGTIEp512WnIbMmQIzjzzTJx//vm4+uqrcd1112HKlCnYuHEjmpubVR9IvpDGy7fA+/RLhZvTTU0euYBdvA+vNWuxiFKJola/sP54EOD9jU04eXJl6MczxK/kwgk/tARPLqlNewBGWkZJmDtiAWat2oPDJ5QhbyiV6O4FvGL0H1qMaeU7Ii3dwvprampw0UUXIS8vL/KWn5+Pww47DBdccAHGjh2L3bt3Z1TMpWTSEkGTx9mhydIKuCZfO0bZ+llhT3unnWYIJ0xLDOtxSiZll9tPyYrFA0wrr8Nhj1Qwv5ZztpGL0W9EKaaV1yFuDBLJuYljn+xuwymPlXcnPHHeHp7xhxUj78FFGL1wK2KCT7VZKh6PY+HChTjjjDMySvjwduCBB+Kuu+7C9u3bvScIKq6sG+VvSzG0FCaLXk7OvohdvA8fFVzUPkkfVVi4z8R+ZzzAvW9vQtEY9+exoXvu4SX9yMU48tEKzFyxi3zE1fLdPRYEAbbv7cDpk5c5Ce/O9qH9Bxdh6N83oz1mH1S3xWIxPPvsszj00EOzlvB5eXkoKirC73//+5SZ3nfcqITiireG3RqXVjlRChm1z8n8rLGLb63VmsQnVSWtuEiyfezsjAe46831Xc+/U/fhE0/SJRJ+xGJ85Y8rULp1bzLhJdyajYn+LU3t+NLkivQZflj4s7jnM5TwUpN0x2IxTJgwAQUFBWTiFhYWYuDAgSgqKkrZBgwYgH79+rEJX1BQgLPPPhsLFixAPB5P080FY6aznAW7pUnxRn1aeMN9FO/nCXuepoCr4lbjOBncdzdZXH6L07s2oC0Wx/WzPul6am70kvT78O6TdsNL8e3nq7G5qYO0Q7KdwhkEXQ8rVe5owYmPhpb04QQfVtLzTH33DN/voWI8WrI9pehog+yOTzwex2OPPcYm7pe+9CUMHToUU6ZMSW7Tpk3DCy+8gF/84hc48sgj0b9/f/a8fuLEiWhraxPHihqzbAV9FL9QfZLdLg0lb1/DLr7xhgMrJSWnWLyg/HoAACAASURBVHMaRWuRLemsa+7EN59bhbyRS4Qn7ULbsFLcOPsTNEf4bTqFJwgCdMQCvLG2HkdOLAslfAkxw/ccLxpajGeX1an4pePt7e24//772YS/7rrrsG3bNnJc6urq8OCDD2Lw4MFswt92223YuHFjks8S9FJ/4rkAjt7FF+ZxeaM0LfEp/VZsPv2WnMokL7zvw3OJSymPBwHaYgFaOuNo7kjdWjrjab//9rEhFgRo7QzQTMhu7ohjb0cci7fuxbnPrHAeunF+Dx+e4YeV4ncLNiYvlmWjtXTEMaF4GwaPWRy6LVeSup9y0a4E+z+8GE8uqU3ilXzB+aeurg633HILm/D33ntv8jYbJae6uhrf+ta3WP6zzjoLH3zwQQpPPB5Ha2srWlpa0Nramtxvb29P0xGPx9HS0oLdu3dj3bp1WLx4MSorK9Henv4WpCAIEIvFkvJqa2tRXV2NiooKLFmyBEuWLEFVVRW2bNmChoYG7N27F52d6c9RUHLb29vT7G1ra0sWkDBtR0cHmpqasGvXLqxbtw7r169HY2Mj+5xCR0cHWlpaUuSH9XR0dIg2dnZ2krwJfgtGt5EJL83A1He3xeIBmtpjKN3WjGEfbcdNr6/Hv82uSW7/PqcGt725EY+X1WHt7jY0tMXEc+Zw6+h+T/3CTU34f+9twfWv1uAHs9alb698gkufr8aBE8tTL9i5b7wZlfrQzUN/32K2xTKjNLTF8ONXP0G/EW6SM1fphxbjlMnL8Gr1HpMNnF2rVq3Ct7/9bTZhx44dmzajhrE0Nzfj5z//Oct/yCGH4OWXX07RWVdXhzvvvBO33XYb7rjjjuT25JNPYs+ePclZuaGhAeXl5bjzzjvxzW9+E+eeey5OPfVU3Hrrrdi1a1cKlo6ODtTX12PBggW444478J3vfAcXXHABzjrrrJRnCE4//XScf/75uOyyy3DllVdi5syZqKmpIQtIorW2tmLKlCm46aabkrbeeuutGDlyJDZv3pz0R0tLC+rq6vDHP/4Rl19+OS6++GKcffbZOOecc3DZZZfhN7/5DTZs2JB2TWPevHn46U9/muKLxHbLLbdgxowZ2Lt3L+n/IAjwwQcf4Prrryf5b7jhBsybNy9Np9bMr6l2G3ee0RELsKy2BT+fvxHHP1GFAx6pROHESvRztqJJlTj40eU4e9rH+P37W7Gm++UPUhK1dcbx7oYm3DinBsdPrsL+EypQOK4c/caWo9/Ypc5Wjnz213PEr+VGLcbBE5biscW15NtkOd9oSd/aGceNL60JXbBTtoeK8a0/f4wK5vVflhaPx/G3v/0NQ4YMYRP2hRdeYE/XErPZPffcI16tf+6551L4165di5NOOgn9+/dPbgMHDsQNN9yAbdu2oaOjA9XV1bjrrrtw6qmnYsCAAUl5BxxwAIYNG4ampqakzPr6esyfPx/XXnstjj76aPaaAnXKceSRR+Kf//mf8eabb6Kjo4P00+bNm3HllVeisLAwaW9hYSEuvvhirFmzBkEQoLa2Fs888wwuvfRSHHroocjPz0/TN2DAAFxxxRWorq5OScD58+fjrLPOSvFHWM9dd92F2tpa0rYgCDBz5kySt3///thvv/3wpz/9qXdneE14PAiwoq4V339lHQZOCr/eyn3dVc/3/PHLcMTkKtw6dwPW1acv/RKtMx7g7xub8LUZ1Rg8aVnop7JLiZ/ISq+4KutZ0o9KvSV3wuOV+Ou6RvUePNfS/QY0tMfwgxdWI++hYtD3350Z/qFi3PTKWmzbSweppC85DvE4Zs6cif3335+9Qv/iiy+K107a2tpw9913s0nVv39/TJ8+Pckfi8Xw4Ycf4vDDD0+7qn/FFVdgzZo1ePXVV5MJ4Mo79thj8fe//x2dnZ0AgMbGRjz55JM444wzzIlObV/84hfxyiuvkElfVlaGr3zlK2k8l156KdavX49t27bhnnvuwZFHHonCwkJRT2FhIW699VY0NDQk/VhdXY2rr76a5bnxxhuxfv16cizb2towZswYlveEE07AnDlzvGNEfKed5fwxTFPfFsP9f9+KARMrnTfehDfnxRjjKlAwvgJHTa7CuJLa5L1nNxh3tXbiJ6/X4IBJFfQLMEa7n6EXYCSSWvp57IjFOO/pKlTvalVxu7Mh1+JBgPX1bbhwWpV5hs9/sBi/++sGtAr/zmO5qDNr1iw2WI455hjMnTuXneEBoKGhAbfddhsrY+DAgZg5c2aSp62tDc8//zwOPvjgtNn2lFNOwS9/+UscffTRrLzzzz8fW7duRRAE6OzsxLx580zJTs247nbcccdh5cqVydk3gfH//u//8MUvfjGN/pxzzsG0adPwox/9iL2tSW1f+cpXUFlZmdRTX1+Pn/3sZyz9VVddhZUrV5JjuG3bNtx5550s75VXXomamho2RriYEX8Pz10U4vYrd7TiyMlVzL/RVKS+4y7xcoxx3Z9jy3HlX9amzPKJz3gQoHRrM475QyXzTjvLSyyVV1yNKMVl01elvGIqygXF8H4sHuDDTU04/YlKJ+HdGT7089iHijFu4Vavq7Xu91gshmnTprHBcsEFF2D58uXikn7r1q34wQ9+wMo46qij8Prrryf5Gxoa8OCDD7KrCi1pv/3tb6OuruvOxPr163H99dezzwPk5+fj0EMPxeWXX45bbrkF1157LQ477DBW/uDBgzFmzJiU0wUAmDp1KqmjX79+acfz8/NRUFAgFpiDDjoIEyZMQEtLC4Cui24PPvggS//1r38dJSUl5FX6kpISXHjhhSz+e++9N7ka8olN8sEbKfm5GS4eBJhf04iDH1nO//VU8l13oaRPJPy4chw1pQp/Wr4r7Ry6pSOOx8p2YHBidh+zlJ/hyZdYcufwqffgb3xlLTqI36H7Xt9ItI5YgD9X7sQ/PVLu/HCG+ZnssBIUjijBqA+2mHRx/c3Nzfif//kfNtCuueYa7NixQ5zhKysr8Y1vfIOVce655+Kjjz5K8m/btg3XXHON+NAOlUAFBQXYf//98cADD6ChoQGxWAyvv/46DjzwQJbviiuuwPz581FdXY3a2lps3LgR7733Hr785S+LRa6hoSEF77PPPqvO4P3798dJJ52E++67D0899RR+9rOfsbcrCwoKcNNNN6G+vj6pY9KkSayOIUOG4O233ybHYP78+WmrpcRWVFSEyZMnsxMClcspCc8xSYyu8I5YgBkrd2PQI8uJv5oKJ3ko8VMSvgL7TVyGBz/Ylnz9VaI1tsfwP+9vxQETK/i31nKvqyaTPfR4bSLph5fiP16vMf39k9VnrZ1x/NeCjRjw8OKeB2yYH8wkbtUdPakcf1pWF1k/0JV8t99+OxvEd9xxR8qtsvDYJo7Nnz8fJ510Eivj+9//PlavXp3UXVdXh3/5l38Rk6ewsBCHHHIITjrpJPzkJz/BY489hhdeeAGzZ8/Gli1bEI/HsXXrVvz6179ml/LHH398yulI4rO9vR333XcfioqKSL6zzz4bjY2NSXs7OzsxcuRIccY+4IADMGLECJSWliaL0ccff4yvfvWrLN/3vvc97NmzJ2nb008/jS984Qsk7WGHHYaXX345bRzj8TjmzJmD/fbbj+T78pe/jA8//NB7BQh43od3hYT3Y/EA89c14NDHqlKTnFrSp/wbTc8Mf/AflmN8SW1awjd3xPFYWR0OnLSMX9KnJLl1hu/5ldzAsWW4/51N4hV6q1MTrTMe4Fdv1jj337lXXHVdsPvnp6vw4cYmVqZFd1VVFS655BI2kIcPHy6emgHArFmzxOX5L3/5S9TV1SV5du7cifPOO4+k7devH4YMGYLhw4dj0aJFWLlyJWpra5P3osP3k1euXInTTjuN1XvzzTenPD+Q4GttbcXUqVMxaNAgku/EE09MWdXU19eztx2Liopw6qmnYs6cOSk/CQaAHTt24Gc/+xlbkL73ve+lzPB/+9vfcPbZZ7MFxb3TkbBt2LBh5MogPz8ft99+e/J2nm/L+KJd8juA8toWHD3ZTXj3NdXp/zWXOIc/+0+r8N7GprSr5LF41z/JnvBEVSjhl6YnPPtXU+7rrZxz+FFLcMQjPT+aieJIqrXF4vjF6+uIX8lRP48tRt5DxbjyuY9RU9+WJku7nhJu77zzDo488kg2acaOHcvKSoz7zJkz2dkyLy8Po0aNSt7jDoIAq1evxnHHHUfSHnvssVi0aBEaGxtTblu5M1QQBFi8eDF7ca9///64//77EYulX2dpbm7GhAkT2CJ13HHHoba2Nkm/fv16fPe73yVp8/Pz8cADD6ClpSXNxzt27MDPf/5zc8KvXbsWl19+OUk7ePBgzJs3L8XvQFfBvvjii1kfPPDAA5GuMQHGGV67gJTor23uxD1vb0Yh9RdTycSvSE34cV1X6ovGV+Cev27q+sslR0+Arv+3+95La1GQeFutm/DhpTz1TvqU38O7Cb8YJz++DEu2NWct2QGgrrkT17yw2pDwiRl+EW55Za3p76S5FgQBFi5cyCbr4MGD8fjjj6fQu62trQ1Dhw4Vz8dnzJiR5O3s7MQ777yTdksuvATdvHmzant7eztmzpzJniMfc8wxeOmll8iLVfX19fjFL37B4j755JOTS20AWLRoEXvOP3jwYEyZMiWlsCTapk2bcO2117K++bd/+7dkwgNdFzO5Jx4HDx6MuXPnpo1fcXExefcg4cuPPvpIXMZTp2iJ5r2kl1oQBKje1YYLn6vu+seY8VTCJ87je/43vnB8Bb7+/Bq8s6Ep7Sm38EXBpdubcf6fViHv4dArq6l78eFbdNJfTY3quQd//tNV2LZXftSRsovrCwJgeW0LLvrTSuIxWibhH1yE387fQP5Bh88YvPXWW+x94xNPPBELFiwQ8WzYsAFXX301e5560EEHYc6cOSnL6WnTpuGggw4i6c855xxs2rRJvTaSWMpK567Lly8nny7bvXs3Lr30Utbm8847D62trUn6uXPn4oADDmCLw1tvvUXq+eSTT3D22WeTegYOHIh777035W5AZ2cnfvvb35J6ioqKMH369NTrPq2t5O3NxPbDH/4w7TSDa17n8NwVastSf3ldC254bT0GTFyGvNHl3X8X5WxjK5A3uhxFYytwzawazKqu736tFC+3PRbg/U1NuPblT1AwZinyRlIX47o396Ebbobvfgf9Fc99jJZOXr9PSyT8G2vqMeSJSvo2nPODmbxhXW+svdcj4an+jo4O8Zbc+eefjzVr1ohyly5dikMOOYSVcckll2DZsmXJhGhoaMCvf/3rlCfnElu/fv3w3e9+V034IAiwfft23HHHHexy+atf/Wry1p0bhw0NDeLbfS699NKUq/TvvPMOe/U8cduSOv3YsGEDjj32WJLvC1/4AqZOnZpSWDo7O3HfffeRBbh///6YOnVqcsUSBAE2b96Ma665hrRt0KBBGDt2rPoMvtRSEp5aurvndtKAhbf1De14adUePPjhtq5n6eekbje8vgH/9e5WvLhqD6p3t6W8lpmSnfiMBwGqd7dh2rKdeOD9rbjx1Rr8+yufJLcfzfoEF8+oxsAJFfJ9+OSfTnQl/aXTV3UnfHaW9EEQYOyibThwXBlxNT71Vlzip7IHjy3D6IVb0R5LfUDEx6b6+no89NBDbOBffvnlycCnxrijowNTpkwRH3j5zW9+kzLLNDY24pprriFpBw4ciPvvvx+7d+8mfRT+3LBhA6688kp2uXzJJZeQF6uCIMC6devYi2P9+vXD/fffn4L7xRdfZBP+O9/5TtovCRN8VVVV7HL7+OOPx3vvvZdyytHe3o4pU6aQpzuFhYVpPzNevnw5TjzxRFL+2WefnfbMvnVSSHySL7FMEFgu2lEFIZz4e9vj2NLUgY0N7SnblqaO5I9mOF7KnsQWD7reSOvK3lDfjulVu3HwI8uEhE99kWXRmCW47fUaNHf4/RBBakEQYNh7m1EwrMT2XvqhxTj5sWV4vXpP2gwvrbbc8di4cSNuuukmNllvv/12cqmakLdu3TrxtVj9+vXDE088gVis5zpDc3Mzvve975H0gwcPxtNPP51yAYzDtX79enz7299mE/Gyyy5Da2trWizEYjHMmDGDvf116KGHYsGCBcnHa9vb2zF+/Hh2+X/DDTek/Kgl0To6OjB79mz2GsPXvva1lB/dJGx799138aUvfYlM+KFDhyZvF7a2tmLSpEnkMwj9+vXDf/zHfyR/madNwNR3wHkvPdesS3ky+ZPfw3K69wXd1PH0IHe3rv63PmlA4cNL6Gfpw1fpu2f3A8cvxeQlO9AW80t4akWU2O+MB3jo3c0oGKokfGJpP7QY//zUclTWtpC/1uP0uMfLy8tx1llnsQl71113dRXM7l/KJd5N39bWhu3bt+PGG29kEy4/Px+XXHIJysvLUx5Tra2tZZ8KO+SQQ/Dmm2+mFAguMDdv3ozrrruOvf5wySWXJM+PwzHZ0tKCW265hbX7n/7pn7Bhw4aknt27d+NXv/oV66Pf/va3yVuFYVsbGxtx1113sfZdddVVKacNQNc99ZqaGnzta18jk/jee+9NnqbU1dWxpyXHHXccPvroo7Q7FNaJOdHYf57hgowKNmkQLXI4GZQ+KeAT26vVe1AwcrHtPvyoxThiwlIsWNfA/gWWho9qWxrb8aOX1iBvqJvcxEW7YV1/M3X5nz9GLXPhUJrdw/3Lly9nL/jk5eXhpptuwtq1a7F69WqsWbMGq1evxsKFCzFixAhcdtll4o9E+vfvj1/96lcpy+p4PI7ly5fj9NNPZ5OtvLycHefwuO3evRsPPPAAe9HulFNOwbx587Br1y60tLSgubkZ27dvx5QpU9jbkPn5+bj55puxY8eOpL6amhpcccUVLM6HHnoomVgJnlgshjVr1rA4Bw8ejFGjRiUfqw1ja2xsxI9+9KM0noKCAvz4xz/Ghg0b0NzcjJdffhlHHHEEWRiuuOKKZGGgfMfFpNsvvuJKC2pJsEUGpY9b9kk6wvztsTgeL9vR9ZabMWXpM3x4Wd99lf74R5clf54r2SbhdvvfXFvf9Ujt8BLnzySL6Rn+oWLc8vIatBLXEbgxoga/oqKCvfqcl9d14eeEE05IbscffzyOPvpo9oGV8Hb++ecnZ5mEzs7OTsydO1e8B19VVaWOO9C1ZH7jjTfIoM/L67qqfdZZZ+EXv/gFpk6dikmTJuGaa67BCSecwF5zOOigg/DBBx+k2Lx06VL2wltRURH+8z//EytWrMDq1auxevVqbN26FQsXLsSVV17J6jnzzDNRVVVFvnmnpaUFN998M8l3zDHHYOTIkZgxYwa+8Y1vkNcvjjjiCMyZMyfluQfL7E7FSNpFO25QuGNavyX5teUqRccVh92tMfzu3S3db7kJ/VqOfACnK+nPnboce1pjIj5uNUHZurcjjv/vvc0oTJy/a+fww0pQMKwYd7++Dm2dqRfsfPTHYjHMnz9fTdwo24EHHohJkyalnEMDXffsx48fz17VP/3001FWVpYWpBye1atX48ILLxQfeU28gHPAgAHiD1ry8/Px05/+NO0NuytWrGDv1/fv3x9HHXUUjjnmmOR2wgkn4OCDD2b1FBUV4e67707+NNbF19jYiLvvvpstFkVFRdhvv/3IU5LE7/M3btzolehc3pC/lpNmUd/j2sxvmc18isa6+jb8cNa6rmV72n340O250Dn8OU+lJjwXnJYiGIt3nVIc82hFT0KnJbxzX35YMb4wbgmeWroj+bNYaSbn/NvS0oKnn346q4ner18/HHLIIRg9ejR5hbytrQ133nkneSpQUFCA6667DjU1NSafBkGA1tZWvPTSSzjppJNMP33ltsSPbBK3A8NbaWmp+vt2H/9885vfxKpVq9i3z7S2tuKPf/wje1FR2g4++GA8//zzySv5bhxYEj+MnbwtRw2EZTkpVW5tdrIENVeQwn0fbdmLL01b2fPkHbmk73kJRsHDS3DVX9agrrlT1Kf5I3F87e42XPuXahSm/Y88l/BdF+zOebISq3e1sq/X0nwIADt37sTvfve7rARyQUEBCgsL8Z3vfAePP/44mpqayHHu7OzEHXfcwSbDf//3f2Pnzp1iwrtYdu3ahWeeeYZ9Nl/bBg0ahHvuuQfr1q1L0xGLxTBr1qyMikm4qFx00UWYO3cu+167IOi6MLpixQrxDUTUVlhYiB/84AfJC46WCYiLm2TCc4FtSTppxrbOiJKhlE1ckCQ+P9jUhAPGl6e+AIOa5btn+P4PL8HQ97egqT0mYrf4YmNDO26f8wkGuMkeTvhh6cv5vKHFuPaF1WhsTz+toGzi9G/atAk33ngjBg8ejP333x/777+/1wsc9ttvPwwaNAhnnnkm7rvvPjzzzDOoqKhIuxUU1t3S0oJf/epXOP3003HmmWembGeccQaef/75tNMAaXwTn83NzaioqMDjjz+Ob33rWzjwwAMxcOBA0u4BAwZg0KBBOOOMM/D73/8eb775Zspz82HZzc3NmDhxIlugDjnkEAwaNEh8Rfd+++2Ho446Cr///e+xePHiNHxUvHZ0dOC1117Dd7/7XZx++ukYMmQIvvzlL4sXWA8//HDMnj075cEcLQ+pmA3Tpl2l1z6pBOCOUQZJvD6Gc3o+2tyE/UaHHrGl7sOHzuEHjl6CF1fuSrklpxXA1P2un8Eu3roXN768pivZh5fwCe8+dTesGMdMXIrnlu9Muy3I66T90NzcjNLSUrz11luYN28eFi5ciOLiYrz33nt4++23MX/+fMydOxevvfYaZs+ejVmzZmH27Nl4/fXX8fbbb2PhwoWYP38+SktLUVdXR96acvc7OzuxcuVKFBcXo7S0NGVbtGgRduzYkfamGW0sw75vaWlBVVUVFixYgPfffx9z5szBzJkz8eyzz2L69Ol4+eWX8e677+Ktt95CcXFx8nydG8O6ujrcddddZILtv//++MlPfoIFCxZg4cKFePXVVzF9+nRMnjwZkyZNwiOPPILnnnsO8+fPx7vvvpvy1B/nn7Dujo4OrFq1CkuXLsXHH3+Mp556CqeeeipbxB544IGUn/RqE5+mHyBuy3GzmaVZk14zzqorLfjiAV76eA8KRi2hEz5xOy50lX7Q6DKUbWtmn+HnvseDAHvbY6jd24kJi7bh4v9dif7DmWRPJnz630vlDy/BBU9XYX19+pKQGlDJX9oYBkHPu9y5/4On+CkfSLOMVOClpNf4gqBrSd7R0YG2tja0t7enFCXNV0EQYN26deQ98by8rltrI0eOTD66GovF0N7ejubm5pS/zg6/wtoXe0LuypUr8cMf/pC82FlUVIQbb7wRGzZsYP3ObRJ2gHjSjqsi0qAFQdftsNrmDqxvaEdNfXa2rU0dyT+FsARFU3scE0pruy7GjSnruS33sHOxLvR47YGjl6BsWzNq9rR1bfXM1t2/pbEddc2dWLqtGcPe34J/nf4xDhtfhnwp2cmr9F0X644YX4apZTvSnvLTCiA3LlYeKVC5Mbb299Z3zXZtwgmCAFu2bGF/1XfooYemPNuebextbW3YvHkzXn31VXz9619HUVFR2rWEoqIiXHLJJfjb3/5G/gw4E+wAUs/huaYFUU19O+asacCPXluPM/53Nb70p8S2Kvo27WP861/WYmrFTlTVtSRfPSUNwLamDtw9b0PPFfox7nLeWdKPWoL8UYtx2hOVOH1qFU6fupzfnuzaznxyOYZMrsQRE8qx/+jFoWQOzeQjhCV96Jdz/YaV4Ft/Xol1e/TZnaveLr02dlzgUMesRYUaF2m24eyR7OBotNh16Tdu3Mg+c3DMMcdg3rx55M9io2Lv7OxEXV0dNmzYgBdffBFXXXUVjj32WPKiYf/+/XHhhRfihRdeSHm+PhvYEy2PM9Q6EKt2teGaWTU44okVKJxYibzENiH85tplPfvjwz+RDb0AI7GNK09+FoyrwBcercT5z67CgpqG5I9KOHtX1LXga9NX97wIg7tol3LhbnHqn0qGflCTso3s3kaU9iT3CCa5pYt2iWQfUYKT/1COeWvr0RHng8iSOFZ6LSElWqnYWgLQUpw0WyXbtJagKysrYy+SDRkyBCtWrMga9iAIUF5ejrvvvhunnnoqBg8ezF5E7d+/Py677DL85S9/SXtaLxvYE419L72W8EEQYO2eNlz1l09QGH6LDZnwzqutEr+Nd15xlfI5vrxrf2w5CsaW4/SnV2LBugbWAUEQoKK2GUc9Vpn6IgzqBRgpD96EXmRpSfiUrRR5I0vSl+5pRSH9ot0BDy/Gfy3YiB3N9IUxn8DXEs4izxIH2uxmKTiWxLHg9g32IOi6aDZnzhw24b/+9a+nXPTLFHsQBJg4caL45qC8vK5fFN5xxx14//33k1f8s4090cSXWFL7ie+d8QAPfrANRROdF1ZOdF9hVeHM9M5rqt2ET5ntu99SO64c+WPKce1La7G5qYMEEwTAyrpWHDGpgnjFlXsOn/rgTWYJ75yrc7N+aHYveKgYt8xaSy7lqcG1NmsB0GT4zhpR+CVe31mbk+G2pqYmjBw5kk28yy+/POW37JJeiz1BEGDy5MnsKURBQQHOPfdcPP3009iyZQt7KpEN7ImW9mu59ESiE39DQzu++/K6roRNLuVDs3xyhidm87S317pL+vLuF2V0v6iyO/EPeXQZnq7YSQKJdf8zzaBx5c6/0HRfnacerU288Sb8umo32UdGnOHDiZ74HFaCfkOL8f2Zq7GyLv19adLgSoNs5c9W42bhbOvJdmtoaMDkyZNx/fXX44YbbkjZrr/+eowZM0b8LzrAD3sQBJg9ezZOPvlk9O/fHwMGDMABBxyAo446Ctdeey2mT5+O8vLylOcceruZfh5L0cyvacSXnlmVOqtPTGyVqa+qTklq5y+nuHP4ZNL3zPT5o8vwP3/fStrb0hnH9OW7UDTafd0Vc+HO/SOKrMzweprPWwAAF6tJREFU4URPT/jC4SX4zoxVWLJtb9qbeV0/u8tFagyk1YE2flzTlucaL7cct/BRcqTZ1Oc40HUBbevWraipqSG37du3R/7baQ77xo0bMXnyZIwYMQLTpk3DX//6VyxduhRr1qxJvir808CeaGnn8JKy8LFZ1fU46Y8fhxI9fMFuWSjhQzO8+wLLlFmfOocPvQ5rbDnyHi7DvQs2IUbY2NwRx1Pldegfntmpd9q5b60Nv9uOSviRpXzCj3ASPnxrLpzww0pQNKIEP3hhNSprW9iLdNkeXG1cLXqtRSUKBq0/0+JloZfkZwN7Z2cnGhoaUF9fj9bW1rTn7T9t7OS/x2pMQRBg8bbmrpdVJpf07gwfuiJP/SlFYuv+f7n0Gd59B17XDP/g+/QM3xkPMHdtPQYkEt1y0W6U5ww/gpvhS4glfE+yHzKuDHfOrcGGhnb1v+ejLOt8Z1Qf3ZJsdxWSqW4tkXwSTZNvWYnkInbzkt5tDW0x/PTNDcgfT83uXJIL76UPX5kfn5roic8jHl+O6VWpP3UMg1qzuw3HP1bZk+TsP88scc7hs72kL0H+8BL0H1mKi59diT+UbFd/fusOkHUQteUf5Sefxvk6G7IterRZ1kenr625iF38M0nOmMT3l1btwXFPruhZwqckfCWR6O7/y3FL+vQLd/ljy3Hd7BpsbuT/RnlvewwPfbAV+aOWhO7Fc7+WI5LdK+FLyav0+cNLUDC8BOc8VYVfvrkei7fuTXta0DIwlL85GovsTAKSsy9bMl15nA6O5tNquYDdtKR3jUt8tnTG8diSHTjsD8vTl/bk/8tR/z6T/sBN6pK+HAPGV+D8Z1fhbxuaUpbEVFJsa+rAzXPWIX+k84ab0cSSXroPn7g6P6qUOX8PJf3wEuQNLUHRiFJc+MwK/O7tjZhbXY9drZ0pf10VdTbSxkGjz3ZSZDvZpOJmoc+mbiv9vopdTHgJXKLi7GntxMwVu/Evz1Vj8KRK9J+wDIXJrULfxiW28rTtgPEVOOyx5bjtzQ2Y90kDe2XbtWtTQzseen8Ljn28EgNHl6FwVBkKRy2ht4edbeRiehte2rWNWIzCEYtRNKIUg0YtxiHjluBfnlmBe9/agD8vq8MHG5tS3sYr+Xdfa1GXk7nQcgW7+Cw9dX5InTe2x7ou4r22ph4TFu/AQwu3Z7wN+2g7pi3biVdW78Ga7vfWJ/RzLTwge9piWLRlL2ZU7cKID7fiofe3ZLb9vWsb+v4WjP1oG6aW7cDra+rxWvUelGzZi7rmTvVts9KynPK7SyvRSUtATSYnR5Lv2yzLVh+d2pJX8y/3mevYxb+aogRxhgdBgFg8QHNHHA3tMTS0ZbY1tsfQ2hln/81VcljYto5YgKYs2JO0qy2GvR1xtHXGk7cHLT70WbppM4lUiDk5liSwzGJaHEg8rl2UTM5mjU6yM4ruXMWecpXeJ7EsQLVjnBwuSaQ+zbEULzfIlgGgdFLNMjhWjJx8zV+uHikRfPxrCT4OI9fv4rEkiySXwqUlbi5jJx+t5RKBM9KnSXKtxkeRbUkIi+wwrRVDFHpXp9TvM/hRG5cwmcqldLj71v7earmEnf0jCmvV8g0036D30ZcJr1YQKFqL46MEiG8xtPR/lgnfGz4K87n7Pvqt9ucKdvIqfdSZTpthNdkWHqsDrbqiJqSmh/PTp5X0mRzjdFgD30dPJjZZ+aMWA5c/F7Czt+UkI7nK4uM8i6HuvsXRWmJpfBotZ4O0L9lkwe3aSdkkybDaqcmgsPjEgBWrJoeTbfGFr+5cw276PbxFGaeAM0xKNE0XB47DwtnEDViUKqsNNoVX02Pxp9TP0Vrl+BRAS9P84Isnk0TRdOYq9jzNcJ9qxxkUpUpKoDh7KSyULksxkugkHq5x8n1tkXxllSXxWzFZ/WrBn4l+S6BL49jXsKdctHODiko4Ky3Hb21UYGq0krMsMqTk4mg1ezh6LUAsNltl+8rjZFgKkUUX5xctrjibKNmSXu5YX8AunsNLDuAASAp9k4rSwfVrlVEaJEuR4Oh9bZNkW/YtsikMkl8s+qSgzwYuSb9mN/Vdku2jO2xDLmBPO4fXEtcVagl0yTCOntqXktLaHwVLFGyZ0HP8Vtuj9Eu6XQxS0FPyOJmuXI3WYjtHw9nU17CTCc8RawZzMjSDLZXO/ZQcGyWxKBwuzvC+ZeA5Giuf73FfHist5ScKjyaL66Nku31U43S4fFJMW5I3l7Cr9+EtCcMlvgUU1c8B0BLS2k/ZLTnQtY1LXo1XKwCU7Va/SPqj2m8NZk23y6v5Q8NNyePs4LBaYi4XsbMJryWPJJQqGFKwS7IlwJITOBsoWZx8n0HgmiXJKH9YA0wKGqqf868WiBLubAe9hilK84nLXMZO3ofXEtI36DjQViMtzrDqpuT5YtHslWgoezT9Ei2172ufFoRas+qWCo8lGTiZmdjX17Cr9+GtAn0clMkgWQcvk+bLH1WvFaOFTktmiSZMl6nvrM1atKPEQVRb+gJ28ffwrgIqcLRgknh7o2kzWRQ+Tk62i1xvNg27VYa26ojaosj6rJJ0X8ZOvpdeM8pXmbQ0seh0K7C2HyW4uZnQsqSyyvQpFL4BpvnY/e47y4Qxu5vVHuss5rMKjFqoqYmoL2BP+394q1Kf2dISiL79Er2luFhwSwHA0VP8Er0vDo7Wws/1aQFKBblWjKy+lPRLzaffgk3rzxXs4n14rVmLhW/yRuWh9GuDS+mTBtcXM1cAfOyI6gsfGVoRs9grHXPlubK14mmRZ8VkpctF7GkX7TRDOGFaYliPUzIpu9x+qw6uz0Lr8lF+kQaA85EFpxQUFr1aseI2zkfUvtQ0PRYbrJisdvZF7OJtOasTOEVRgHNyKDvd41JiZMOpFG6On8It+cmqj+ORgtJXDjfemWC32CfZrfVr+v+BvauRt+W4RNCMlPitjuRkUHRSskvHJIdIxyX8ln4Ldi7wNB3aOEm0Ueymxl6zm8NuDWYJk6aD0tUXsatvvKGCxOpIC43kAE2Wrx3agGiyORqrzVGa76BGpbUEbBT9mbSoBTGKnr6C3evfY6mZQioIXBHx0RmlUXb68Fgcaiksmr4ofdYWNYi1mU6yz0efxK/Rac03GfoSdvbBG2vSavzZOOY6wtcZVIGS9Eu6sqU7Ez/6yJCwa3zZmsWiJJCvTEmWrw9zGTuZ8JnMzJb+TJsE2GewMk3o3lra9bb/KH1RiiElQ9PD8VhnSF+dUeXkKnbv11S7Cn0dY5WbSX+UPqsO38HmVko+9mTafAKSCsTPyiarnGzZ0Rewe83wmS5BfJagUVs2Ej6qHVGqfCbNt4BZC6lb/HtjeUvtRxmfTGPK9U2uY1f/TFI7Zp25sj1jSv29uVTPdtJm0rKxYnLpMvVdlBa1uGYjIV3cuY7dO+GzSe8r25KIvsWCO/ZZJjLVMj0l8CmUn6eixrVMV52urL6CXfxvOVeJ5AxNBpdE1HmTlNwSWG3QLHIlmzh5nAyJVpMjybUuPzl/cvqs/qP8wtlFYaD8w8mk8Eh4Lfq4sekL2MmEpwzWnCIFImW0tZ8zXLOT67M0DYekW5NpkW8pFj72WbBzY+jjN0m2u88ds+r1sckntjl7orbPG3b1BRiZgLZUO4lPKyxWPonfN5Ekek2/1U7XVi3hfRJaa9LMYmlaseUCnKK3+ieKTVRfX8AuPniTrSqj8VsLQ6YVl+KPWpSi6o9Kl4md1iDKVI9vy2RG9Ql6Xzuovmy3zwq7+RVXmlMsFYnjp2Ros7h23HWK76ydjeY7gNnWbZ35rbJ8ZFjG0qf5zrTa6sgqN9ewm56ld/u1qmRJboueKDS9lbw+erM982SLzleGNo6cHJ+irOnOtFkmqr6EPc89QBFTwSwlfdT+qLORhd8621uOZdrP2Zctm6w4M7XDt18Lep/Z1BJX2bQ90/7PC/Y8l5AyhFLC9WugLYlOFRXuOFeMuKCnaLg+jl46ZtHJ2WCVLflak2fB40tDjY3bLPxRx4hrVt6+hJ18iWWYSBNoCXjumKRXClzJBsp2Dcun0aRBduncfSkAJD7KBs0+Xz6tSZilwNXGWYoTX9v7EnZ2SU8Zbg0YKTG1gJeMtdogOZKrfFGaVuQy3Xd1UbQWP/r4xNrvY79UnMLfo8SCNTaj9uUadvZJO80YKxCLHE4GpU8KeEtF5TBYip70XWtRqjHXr1V3CadFFyVXCnIp6Lhxs/Bz4ynxW+VQsig+isdiO9f/WWNPeaddJkEtOVXi8QHpA07SZ6mmVl9YB02zxVKYtOCx2Odjk9UuSa+kx6KDkyfFraRP0s3R5hL2PKlTM9bSbw1KilZzjiVZKL2WykjJkPRbsPvwa8XQpxBqWCx0rl4tATgbKRnW8eT4Lc2SWH0Be8p9eEqpJMBynAsuTgfnFKtubVC0JKRskJysOV4bZC7ROcxaIdD0W/zjE1zWwLPI5oLeMuZR9fc17GkzvJQYUhBaA1v7ToHgCgCVrJwTtISV8Fr8wenldGnBJNkv+UMLEInOd7ysOLSEso5NFN0W/X0Ju3ofnmJ0aSUDOSAWQymbuIGhPq1yOQyczZZAoHRwPtN0ucc1PVaZFj0ujRZsWqBSdNK4WWywxJoUI30Je9pVeksS+SSyT5D7DpokQ0porp+SZcUv0fjuW2m5gKDoqUCRMPhglMZY86FFD2efllCc/r6MnU14iklr1qTXjLPq8kkejsfqdM5+LpE0eleulV6y3bcgcs0a8Nagl2RwNlmKNbdRdluKndSXK9jTnrTjqogFvHTM0i/JtTjGos8yCJoNln6tuPjKljBF4bHo13T5YMvGd812KVm5GIga3/sq9jwKEMWUjWZJOspIy3HOTqnqcbzavuQziV4bHMpGKzZLEdUwaMGnHZMKiMSrYZForLHpO6a5ij3P4gjNGHef6/cpLpYE4eRr1U5rUQuLlHRS8EhBZJFnpdfGS6KVfGIZW0tx0myVbNOatTjmOnb2vfRawluCSEteSZbbz9moyaBst3zXMEnfNbkSVheLxV9W7JI8iU/DIdFQ+rXEseD2DXbLGPQF7OT/w7vfNSM5kNS+JpuzwQKG69NspGzycSgl18IvyY0ix1oALLqtuqLyS7w+NmiJGEW/hS4Tfom3t7Gn/VrOmpwUnSWJrMnuAvFpUvHKVIdW9X3orc1XJ8efrcaNZbb1fB7bvo7d9PNYicZ1gFQorDNvWK5vs8y6mlwrncSfzeTm7LGsXCRaq35ri1rUuQSSbPA9bml9AXvaObykjAu4KMsQabbSdFuWLtlIBs3pvokl8fR2YPvOTNpYUGMX1dZs+thXvzbpWGzal7CbXmKpzSy+Qa5VQl96zV4rbSazg1VHNmkpnmzMcFbZWgH31R0lTnxWLlKx6yvYzUt6TlA2mk8BCff78vna4R7LJLGynfThGdtntRPVbosfslFsLCsQN9l8dVj5chE7+fNYzZiozSKLcqLVBi34fVcimo2+Do8aZO53yi/ZXPVY7cvmiogKZGlWzmZc+thI2ZUNuZ8WdvN76V06bbkh8XJyrDSa3ijJ69sfZTmVzVneZ/CznRTZTraoK7ze0G2l31exiwkvgYsSYFErY9RB6a3WGwm8L7SoxSsXWq5gF5+lp5bI4WO+szG35Ka+a6cYnA5XBiXXl1dbzVgKo4+/JP2Sbg2DhImSI8n3bZZlq49ObclrHRPOnlzFLv63HCXIYrgki3M2B4YzXHKYJakleZZAiIrbaotEQ8mUdHC+l2RadUcNUE4mZ7NGJ9kZRXeuYk+5Su+TWBag2jFOjpRQUgJJjqV4uUG2DAClk2qWwbFi5ORr/nL1SIng419L8HEYuX4XjyVZJLkULi1xcxk7+WgtlwickT5Nkms1PopsS0JYZIdprRii0Ls6pX6fwY/auITJVC6lw9239vdWyyXs7B9RWKuWb6D5Br2Pvkx4tYJA0VocHyVAfIuhpf+zTPje8FGYz9330W+1P1ewk1fpo8502gyrybbwWB1o1RU1ITU9nJ8+raTP5Binwxr4PnoyscnKH7UYuPy5gJ29LScZyVUWH+dZDHX3LY7WEkvj02g5G6R9ySYLbtdOyiZJhtVOTQaFxScGrFg1OZxsiy98decadtPv4S3KOAWcYVKiabo4cBwWziZuwKJUWW2wKbyaHos/pX6O1irHpwBamuYHXzyZJIqmM1ex52mG+1Q7zqAoVVICxdlLYaF0WYqRRCfxcI2T72uL5CurLInfisnqVwv+TPRbAl0ax76GPeWinRtUVMJZaTl+a6MCU6OVnGWRISUXR6vZw9FrAWKx2SrbVx4nw1KILLo4v2hxxdlEyZb0csf6AnbxHF5yAAdAUuibVJQOrl+rjNIgWYoER+9rmyTbsm+RTWGQ/GLRJwV9NnBJ+jW7qe+SbB/dYRtyAXvaObyWuK5QS6BLhnH01L6UlNb+KFiiYMuEnuO32h6lX9LtYpCCnpLHyXTlarQW2zkazqa+hp1MeI5YM5iToRlsqXTup+TYKIlF4XBxhvctA8/RWPl8j/vyWGkpP1F4NFlcHyXb7aMap8Plk2Lakry5hF29D29JGC7xLaCofg6AlpDWfspuyYGubVzyarxaAaBst/pF0h/Vfmswa7pdXs0fGm5KHmcHh9USc7mInU14LXkkoVTBkIJdki0BlpzA2UDJ4uT7DALXLElG+cMaYFLQUP2cf7VAlHBnO+g1TFGaT1zmMnbyPryWkL5Bx4G2GmlxhlU3Jc8Xi2avREPZo+mXaKl9X/u0INSaVbdUeCzJwMnMxL6+hl29D28V6OOgTAbJOniZNF/+qHqtGC10WjJLNGG6TH1nbdaiHSUOotrSF7CLv4d3FVCBowWTxNsbTZvJovBxcrJd5HqzaditMrRVR9QWRdZnlaT7MnbyvfSaUb7KpKWJRadbgbX9KMHNzYSWJZVVpk+h8A0wzcfud99ZJozZ3az2WGcxn1Vg1EJNTUR9AXva/8NblfrMlpZA9O2X6C3FxYJbCgCOnuKX6H1xcLQWfq5PC1AqyLViZPWlpF9qPv0WbFp/rmAX78NrzVosfJM3Kg+lXxtcSp80uL6YuQLgY0dUX/jI0IqYxV7pmCvPla0VT4s8KyYrXS5iT7topxnCCdMSw3qckknZ5fZbdXB9FlqXj/KLNACcjyw4paCw6NWKFbdxPqL2pabpsdhgxWS1sy9iF2/LWZ3AKYoCnJND2ekelxIjG06lcHP8FG7JT1Z9HI8UlL5yuPHOBLvFPslurV/T/w/sXY28LcclgmakxG91JCeDopOSXTomOUQ6LuG39Fuwc4Gn6dDGSaKNYjc19prdHHZrMEuYNB2Urr6IXX3jDRUkVkdaaCQHaLJ87dAGRJPN0VhtjtJ8BzUqrSVgo+jPpEUtiFH09BXsXv8eS80UUkHgioiPziiNstOHx+JQS2HR9EXps7aoQazNdJJ9Pvokfo1Oa77J0Jewsw/eWJNW48/GMdcRvs6gCpSkX9KVLd2Z+NFHhoRd48vWLBYlgXxlSrJ8fZjL2MmEz2RmtvRn2iTAPoOVaUL31tKut/1H6YtSDCkZmh6OxzpD+uqMKidXsXu/ptpV6OsYq9xM+qP0WXX4Dja3UvKxJ9PmE5BUIH5WNlnlZMuOvoDda4bPdAniswSN2rKR8FHtiFLlM2m+BcxaSN3i3xvLW2o/yvhkGlOub3Idu/pnktox68yV7RlT6u/NpXq2kzaTlo0Vk0uXqe+itKjFNRsJ6eLOdezeCZ9Nel/ZlkT0LRbcsc8ykamW6SmBT6H8PBU1rmW66nRl9RXs4n/LuUokZ2gyuCSizpuk5JbAaoNmkSvZxMnjZEi0mhxJrnX5yfmT02f1H+UXzi4KA+UfTiaFR8Jr0ceNTV/ATiY8ZbDmFCkQKaOt/Zzhmp1cn6VpOCTdmkyLfEux8LHPgp0bQx+/SbLdfe6YVa+PTT6xzdkTtX3esKsvwMgEtKXaSXxaYbHySfy+iSTRa/qtdrq2agnvk9Bak2YWS9OKLRfgFL3VP1Fsovr6AnbxwZtsVRmN31oYMq24FH/UohRVf1S6TOy0BlGmenxbJjOqT9D72kH1Zbt9Vtj/f2N/MeGvrCrnAAAAAElFTkSuQmCC" alt="">
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold; padding:3px 0px; font-family: 'Francois One', sans-serif;">
                    {{$order['customer']['name']}}
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold; padding:3px 0px;font-family: 'Francois One', sans-serif;">
                    {{$order['customer']['phone']}}
                </td>
            </tr>
            <tr>
                <td style="padding:3px 0px;font-style:italic;font-size:12px; line-heght:1em;">
                    {{$order['customer']['address']}}<br/> {{$order['customer']['district_name']}},  {{$order['customer']['city']}}, {{$order['customer']['province']}}
                </td>
            </tr>
        </table>

        <table style="width:600px;margin:auto;  border-collapse: collapse; margin-top:10px;">
           <thead>
                <tr>
                    <th style="border-bottom:1.5px solid #ddd; padding:10px 0px; text-align:left; font-family: 'Francois One', sans-serif;"">
                        Items
                    </th>
                    <th style="border-bottom:1.5px solid #ddd; padding:10px 0px; text-align:right; font-family: 'Francois One', sans-serif;"">
                        Harga
                    </th>
                </tr>
           </thead>

            <tbody>
                <tr>
                    @foreach ($order['detail'] as $item)
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:left;">
                            {{$item['product']['name']}}
                        </td>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:right;">
                            Rp  {{number_format($item['product']['price'])}}
                        </td>
                    @endforeach
                    <tr>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:left;">
                            Ongkos kirim
                        </td>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:right;">
                            Rp {{number_format($order['shipping_fee'])}}
                        </td>
                    </tr>
                    @if ($order['payment_type'] == 'cod')
                    <tr>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:left;">
                            Biaya COD
                        </td>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:right;">
                            Rp {{number_format($order['cod_fee'])}}
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:left;">
                            Biaya Transfer
                        </td>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:right;">
                            Rp 4,400
                        </td>
                    </tr>
                    <tr>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:left;">
                            Kode Unik
                        </td>
                        <td style="border-bottom:1px dotted #87c5e9; padding:10px 0px; text-align:right;">
                            Rp {{number_format($order['unique_fee'])}}
                        </td>
                    </tr>
                    @endif
                </tr>
            </tbody>

            <table style="margin-top:30px; background:#dddddd40;width:600px; border-radius:3px; font-family: 'Francois One', sans-serif; color:#067e73;">
                <thead>
                    <tr>
                        <th style="padding:15px 0px; text-align:left;font-size:17px;">TOTAL</th>
                        <th style="padding:15px 0px; text-align:right;font-size:17px;">Rp {{number_format($order['total'])}}</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="border-top:1px solid #fff;padding:10px 0px;color:#599df4;letter-spacing:5px;font-size:20px;text-align:center;">
                            {{$order['paid_at'] ? 'LUNAS' : 'UNPAID'}}
                        </th>
                    </tr>
                </thead>
            </table>

            
        </table>
    </div>

</body>
</html>