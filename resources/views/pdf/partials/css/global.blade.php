<style>
@font-face {
  font-family: 'AvenirNextLTW01-Medium';
  src: url('{{storage_path('fonts/')}}AvenirNextLTW01-Medium.ttf') format("truetype");
  font-weight: 400;
  font-style: normal; 
}

@font-face {
  font-family: 'AvenirNextLTW01-Bold';
  src: url('{{storage_path('fonts/')}}AvenirNextLTW01-Bold.ttf') format("truetype");
  font-weight: 700;
  font-style: normal; 
}

body {
  color: #000000;
  font-size: 11pt;
  font-family: 'AvenirNextLTW01-Medium', Arial, sans-serif;
  font-weight: 400;
  line-height: 1;
}

strong {
  font-family: 'AvenirNextLTW01-Bold', Arial, sans-serif;
  font-weight: 700;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
}

td {
  font-family: 'AvenirNextLTW01-Medium', Helvetica, Arial, sans-serif;
  padding: 0;
  vertical-align: top;
}

th {
  font-family: 'AvenirNextLTW01-Medium', Helvetica, Arial, sans-serif;
  font-weight: 400;
  text-align: left;
}

img {
  border: 0;
  vertical-align: middle;
}

table {
  width: 100%;
}

table td {
  text-align: left;
  vertical-align: top;
}

h1, h2, h3 {
  font-family: 'AvenirNextLTW01-Bold', Helvetica, Arial, sans-serif;
  font-weight: 700;
}

p {
  margin-bottom: 5mm;
}

ul, li {
  margin: 0;
  padding: 0;
}

li {
  margin-left: 4mm;
}

/* Helpers */
.align-right {
  text-align: right;
}

.align-left {
  text-align: left;
}

.clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}

.text-base {
  font-size: 11pt
}

.text-sm {
  font-size: 8pt
}
</style>