const today_data = new Date();
const formattedDate = today_data.toLocaleDateString("en-US", {
  day: "2-digit",
  month: "short",
  year: "numeric",
});
document.getElementById("demo").innerHTML = `Today (${formattedDate})`;

//
