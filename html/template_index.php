<!DOCTYPE html>
<html>
<head>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; text-align: left; cursor: pointer; }
        tr:hover { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>{{ title }}</h2>
    <table id="sortableTable">
        <thead>
            <tr>
                {% for col in columns %}
                    <th onclick="sortTable({{ loop.index0 }})">{{ col }}</th>
                {% endfor %}
            </tr>
        </thead>
        <tbody>
            {% for row in rows %}
                <tr>
                    {% for cell in row %}
                        <td>{{ cell }}</td>
                    {% endfor %}
                </tr>
            {% endfor %}
        </tbody>
    </table>

    <script>
        function sortTable(colIndex) {
            const table = document.getElementById("sortableTable");
            const tbody = table.tBodies[0];
            const rows = Array.from(tbody.querySelectorAll("tr"));
            const isAscending = table.getAttribute("data-sort-dir") !== "asc";

            rows.sort((a, b) => {
                const aText = a.cells[colIndex].innerText.trim();
                const bText = b.cells[colIndex].innerText.trim();
                const aNum = parseFloat(aText);
                const bNum = parseFloat(bText);

                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return isAscending ? aNum - bNum : bNum - aNum;
                } else {
                    return isAscending
                        ? aText.localeCompare(bText)
                        : bText.localeCompare(aText);
                }
            });

            rows.forEach(row => tbody.appendChild(row));
            table.setAttribute("data-sort-dir", isAscending ? "asc" : "desc");
        }
    </script>
</body>
</html>
